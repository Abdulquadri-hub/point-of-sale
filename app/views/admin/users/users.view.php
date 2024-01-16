<?php $this->view("includes/a-header",$data) ?>
<?php $this->view("includes/a-body-header",$data) ?>
<?php $this->view("includes/a-sidebar",$data) ?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1><?=$title?></h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=ROOT?>/dashboard">Home</a></li>
            <li class="breadcrumb-item">Pages</li>
            <li class="breadcrumb-item active"><?=$title?></li>
          </ol>
        </nav>
    </div>
    
    <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">

                <div action="" class="d-flex my-4">
                    <input type="text" class="form-control me-2 js-search-user" style="width: 400px;" type="search" placeholder="Search by email or name">
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
                <h5 class="card-title">All <?=$title?>
                    <!-- <a href="<?=ROOT?>/dashboard/products/add">
                        <button class="btn btn-sm btn-primary float-end"><i class="bi bi-plus"></i>Add New Product</button>
                    </a> -->
                </h5>

              <!-- message -->
              <?php if(!empty(message())): ?>
                    <div class="d-flex justify-content-center align=items-center alert alert-success">
                      <?=message('', true)?>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped">
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>Email</td>
                                <td>Role</td>
                                <td>Date</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody class="js-users-tbody">

                        </tbody>
                </table>
                <?=$pager->display()?>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
</main>

<!-- edit user modal -->
<?php $this->view("dashboard/users/edit") ?>


<?php $this->view("includes/a-footer",$data) ?>
<script>

    function send_data(data,type)
    {
        var form = new FormData();
        for (key in data)
        {
            form.append(key, data[key]);
        }

        form.append('data_type', type);

        var ajax = new XMLHttpRequest();
        ajax.addEventListener("readystatechange",function(){
            if(ajax.readyState == 4)
            {
                if(ajax.status == 200)
                {
                    handle_result(ajax.responseText);
                }
            }
        });

        ajax.open("POST", "users_ajax", true);
        ajax.send(form);
    }

    function handle_result(result)
    {
        
        var obj = JSON.parse(result);

        if(typeof obj != "undefined")
        {
            if(obj.data_type == "read")
            {
                refresh_users_data(obj.data);

            }else
            if(obj.data_type == "search")
            {
                
                refresh_users_data(obj.data);
                
            }else
            if(obj.data_type == 'delete')
            {
                alert(obj.status);
                send_data({}, 'read');

            }else
            if(obj.data_type == 'edit')
            {
                alert(obj.status);
                send_data({}, 'read');   
            }else
            if(obj.data_type == 'get-row')
            {
                let row = obj.data;
                let editmodal = document.querySelector(".js-edit-modal");

                if(typeof row == "object")
                {
                    for (key in obj.data) {

                        let input = editmodal.querySelector("#"+key);
                        if(input != null)
                        {
                            input.value = row[key];
                        }
                    }
                }
            }
        }
    }


    document.querySelector(".js-search-user").addEventListener("input", search_user);
    function search_user(e)
    {
        var text = e.target.value.trim();

        if(text == "")
        {
            return;
        }


        var obj = {};
        obj.text = text;

        send_data(obj, "search");
       
    }

    function edit_user(e)
    {
        e.preventDefault();

        let obj = {};
        let inputs = document.querySelectorAll('.js-edit-input');

        for (let i = 0; i < inputs.length; i++) {

            if(inputs[i].type == 'file')
            {
                obj[inputs[i].id] = inputs[i].files[0];
            }else{
                obj[inputs[i].id] = inputs[i].value;
            }
            // inputs[i].value = "";
        }
        send_data(obj, 'edit');
        hide_modal(e,'edit-user');
    }

    function get_row(id)
    {

        var obj =  {};
        obj.id = id;
        send_data(obj, 'get-row');
    }

    function delete_user(id)
    {
        if(!confirm("Are you sure you want to delete this user ?"))
        {
            return;
        }

        var obj = {};
        obj.id = id; 
        send_data(obj, 'delete');
    }

    function refresh_users_data(obj)
    {
        let users_tbody = document.querySelector(".js-users-tbody");
        users_tbody.innerHTML = ""; 

        if(typeof obj == "object")
        {
            for (var i = 0; i < obj.length; i++) 
            {
                users_tbody.innerHTML += users_html(obj[i], i);
            }
        }  
    }

    function show_modal(e,modal)
    {
        if(modal == "edit-user")
        {
            var mydiv = document.querySelector(".js-edit-user"); 
            mydiv.classList.remove("hide");
        }
  
    }

    function hide_modal(e,modal)
    {
        if(e == true || e.target.getAttribute("role") == "close-button")
        {
            if(modal == "edit-user")
            {
                var mydiv = document.querySelector(".js-edit-user"); 
                mydiv.classList.add("hide");
            }
        }
    }

    function users_html(row,index)
    {
        return `
        <tr>
            <td>${row.name}</td>
            <td>${row.email}</td>
            <td>${row.role}</td>
            <td>${row.date_created}</td>
            <td class="d-flex">
                <button onclick="show_modal(event,'edit-user');get_row(${row.id})" class="btn btn-sm btn-info me-2"><i class="bi bi-pencil"></i></button>
                <button  onclick="delete_user(${row.id})" class="btn btn-sm btn-danger js-delete-user"><i class="bi bi-trash"></i></button>
            </td>
        </tr> 
        `;
    }

    send_data({}, "read");
</script>