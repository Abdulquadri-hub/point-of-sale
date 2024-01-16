   const addModal = new bootstrap.Modal('#add-new-modal', {});

    send_data({}, 'read');

    function send_data(data, type)
    {
        var form = new FormData();
        for (key in data)
        {
            form.append(key, data[key]);
        }

        form.append('data_type', type);

        var ajax = new XMLHttpRequest();
        ajax.addEventListener('readystatechange', function(){

            if(ajax.readyState == 4 &&  ajax.status == 200)
            {
                handle_result(ajax.responseText);
            }
        });

        ajax.open('POST', 'api.php', true);
        ajax.send(form);
    }

    function handle_result(result)
    {
         
        var obj = JSON.parse(result);
        if(typeof obj == "object")
        {  
            if(obj.data_type == 'read')
            {
                let tbody = document.querySelector(".js-table-body");

                let str = "";
                if(typeof obj.data == "object")
                {
                    for (let i = 0; i < obj.data.length; i++) 
                    {
                        let row = obj.data[i];
                        str += `<tr>
                                    <td>${row.id}</td>
                                    <td>${row.name}</td>
                                    <td>${row.email}</td>
                                    <td>${row.age}</td>
                                    <td>
                                        <img src='${row.image}' width=100>
                                    </td>
                                    <td>${row.city}</td>
                                    <td>
                                        <button onclick='edit_row(${row.id})' class="btn btn-sm btn-info">
                                            Edit
                                        </button>
                                        <button onclick='delete_row(${row.id})' class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                     </td>
                                </tr>`;
                    }
                }

                tbody.innerHTML = str;
            }else
            if(obj.data_type == 'save'){
                alert(obj.status);
                send_data({}, 'read');   
            }else
            if(obj.data_type == 'delete'){
                console.log(result);  
                alert(obj.status);
                send_data({}, 'read');   
            }
        }else{
            alert("Error Occur");
        }
    }

    function preview_image(file)
    {
        let allowed = ['image/jpeg', 'image/jpg', 'image/webp', 'image/png'];

        if(!allowed.includes(file.type))
        {
			alert("only supported images are: " + allowed.toString().replaceAll("image/", ""));
			return;
        }
        document.querySelector(".js-preview-image").src = URL.createObjectURL(file);
    }

    function add_new(e) 
    {
        e.preventDefault();

 new \Core\Pager($sale->limit)
        send_data(obj, 'save');
        addModal.hide();
    }

    function edit_row(e) 
    {
        e.preventDefault();

        let obj = {};
        let inputs = e.currentTarget.querySelectorAll('input','select','textarea');

        for (let i = 0; i < inputs.length; i++) {

            if(inputs[i].type == 'file')
            {
                obj[inputs[i].id] = inputs[i].files[0];
            }else{
                obj[inputs[i].id] = inputs[i].value;
            }
            inputs[i].value = "";
        }
        send_data(obj, 'edit');
        editModal.hide();
    }

    function delete_row(id) {
        if(!confirm("Are sure you want to delete row number "+id+"!"))
        {
            return;
        }

        send_data({id:id}, 'delete');
    }
