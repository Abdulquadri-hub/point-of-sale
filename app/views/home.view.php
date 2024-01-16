<?php $this->View("includes/header",$data) ?>
<?php $this->View("includes/nav",$data) ?>
<style>
    html {
        scroll-behavior: smooth;
    }

    
    ::selection {background-color: #343a40;}

    ::-webkit-scrollbar {
        width: 7px;
        height: 6px;  /* fo horizon*/
    }

    ::-webkit-scrollbar-thumb {
        background-color: #343a40;
        border-radius: 10px;
    }


    .hide{
        display: none;
    }

    @keyframes appear{

        0%{opacity: 0;transform: translateY(-100px);}
        100%{opacity: 1;transform: translateY(0px);}
    }

    .pos-section {
        margin: 10px 0px 10px 0px;
        transition: all ease-in 0.3s;
        overflow: hidden;
    }

    /* .pos-section .pos-item-section {
        border: 1px solid black;
        
    } */

    .pos-section .pos-item-section .pos-item-heading {
        padding: 10px 10px;
        font-family: verdana;
        text-align: center;
        vertical-align: center;
        transition: ease 0.3s;
    }

    .pos-section .pos-item-section .pos-item-heading h4 {
        font-size: 24px;
        margin-top: 4px;
        color: #343a40;
    }

    .pos-section .pos-item-section .pos-item-heading h4 i {
        font-size: 20px;
    }

    .pos-section .pos-item-section .pos-item-heading h4 i:hover {
        color: white
    }

    .pos-section  .js-products {
        z-index: 999;
        background-color: #fff;
        padding: 20px 10px;
        transition: all 0.3s ease-in-out;
        background-color: #fff;
        height: 65vh;
        overflow-y: scroll;
    }

    .pos-section  .js-products:hover {
      border-color: #fff;
      box-shadow: 0 0 29px 0 rgba(16, 110, 234, 0.2);
    }

    .pos-cart-section {
        padding: 10px 10px;
        font-family: verdana;
        text-align: center;
        transition: ease 0.3s;
        overflow: hidden;
    }

    .button-checkout {
        padding: 10px 10px;
        background-color: #14a6c7;
        color: #fff;
        outline: none;
        border: none;
        font-weight: bold;
        font-size: 17px;
        margin-right: 10px;
        border-radius: 10px;
      box-shadow: 0 0 29px 0 rgba(16, 110, 234, 0.1);
    }
    .button-clearall {
        padding: 10px 10px;
        background-color: #343a40;
        color: #fff;
        outline: none;
        border: none;
        font-weight: bold;
        font-size: 17px;
        margin-right: 10px;
        border-radius: 10px;
      box-shadow: 0 0 29px 0 rgba(16, 110, 234, 0.1);
    }

    .total-cart {
        background-color: #fff;
        color: #343a40;
        z-index:800;
        font-size: 18px;
        padding: 10px 0;
    }

</style>
<div class="row pos-section">
    <!--items -->
    <div  class="pos-item-section col-md-6 col-lg-6 js-product-items">
        <div class="row pos-item-heading">
            <div class="col-md-6 col-lg-6 ">
                <form class="d-flex align-items-center">
                    <input type="text" class="form-control me-2 js-search-items" type="search" placeholder="Search" name="">
                        <button class="btn btn-outline-dark" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                </form>
            </div>

            <div class="col-lg-6 col-md-6 pos-item-title">
                <h4>
                    <i class="fas fa-shopping-bag"></i>
                    Items
                </h4>
            </div>

        </div>

        <!-- products -->
        <div class="js-products d-flex flex-wrap">

        <!-- items -->


        </div>
    </div>

    <!-- Cart -->
    <div  class="col-md-6 col-lg-6 pos-cart-section">
        <div>
            <center>
                <h4 onclick="show_modal(event,'change')">
                    <i  class="fas fa-shopping-bag"></i>
                    Bag
                    <span class="badge rounded-pill bg-primary js-item-count">0</span>
                </h4>
            </center>
        </div>

        <div class="table-responsive" style="height: 250px;">
            <table class="table table-striped table-hover">
                <tbody class="js-item-list-div">
                <!-- lists of carts -->
                </tbody>
            </table>
        </div>

        <!--  -->
        <div class="total-cart my-2 js-gtotal mt-5">Total: $0.00</div>

            <button onclick="show_modal(event,'amount')" class="button-checkout">
                Checkout
            </button>
            <button class="button-clearall js-clear-item ">
                Clear All
            </button>
    </div>
</div>


<!-- Modals -->

<!-- amount modal -->
<div role="close-button" onclick="hide_modal(event,'amount')" class="js-amount-paid hide" style="animation: appear .5s ease; background-color:#00000088;height:100%;width:100%;position:fixed;left:0px;top:0px;z-index:4;">
    <div class="shadow js-modal" style="background-color:white;width:500px;min-height:200px;padding:10px;margin:auto;margin-top:150px">
        <h4 class="">Checkout 
            <button role="close-button" onclick="hide_modal(event,'amount')"  class="btn btn-sm btn-outline-danger float-end"><i class="fas fa-times" role="close-button"  onclick="hide_modal(event,'amount')" ></i></button>
        </h4>
        <input type="text" class="form-control my-3 js-amount-input" placeholder="Enter amount paid">

        <button role="close-button" onclick="hide_modal(event,'amount')" class="btn btn-sm btn-outline-secondary">
            Cancel
        </button>
        <button onclick="valdate_amount_paid(event)" class="btn btn-sm btn-outline-dark float-end">
            Next
        </button>
    </div>
</div>
<!-- ends amount modal -->

<!-- change modal -->
<div role="close-button" onclick="hide_modal(event,'change')" class="js-change hide" style="animation: appear .5s ease; background-color:#00000088;height:100%;width:100%;position:fixed;left:0px;top:0px;z-index:4;">
    <div class="shadow js-modal" style="background-color:white;width:500px;min-height:200px;padding:10px;margin:auto;margin-top:150px">
        <h4 class="">Change 
            <button role="close-button" onclick="hide_modal(event,'change')"  class="btn btn-sm btn-outline-danger float-end"><i class="fas fa-times" role="close-button"  onclick="hide_modal(event,'change')" ></i></button>
        </h4>
        <div class="my-3 js-show-change text-center m-auto border" style="font-size: 60px;">0.00</div>

        <center>
        <button role="close-button" onclick="hide_modal(event,'change')" class="btn btn-lg btn-outline-secondary mt-3">
            Continue
        </button>
        </center>
    </div>
</div>
<!-- ends amount modal -->


<!-- end modals -->

 <script src="<?=ROOT?>/assets/js/bootstrap.bundle.js"></script>

 <script>
   

    var PRODUCTS = [];
    var ITEMS = [];
    var GTOTAL = 0;
    var CHANGE = 0;

    function send_data(data)
    {
        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(e){

            if(ajax.readyState == 4)
            {
                if(ajax.status == 200)
                {
                    handle_result(ajax.responseText);

                }else{

                    console.log("An error occured. "+ajax.status +" Error Message: "+ajax.statusText);
                }
            }
        });

        ajax.open("POST", "<?=ROOT?>/ajax", true);
        ajax.send(JSON.stringify(data));
    }

    function handle_result(result)
    {
        // convert the result to an object
        var obj = JSON.parse(result);
        
        if(typeof obj != "undefined")
        {
            if(obj.data_type == "read")
            {
                refresh_products(obj);

            }else
            if(obj.data_type == "search"){ 
                
                refresh_products(obj)
            }else
            if(obj.data_type == "checkout"){ 
                
                alert(obj.status);
                console.log(result);
            }

        }
    }

    function refresh_products(obj)
    {
        var mydiv = document.querySelector(".js-products");
        mydiv.innerHTML = ""; 
        PRODUCTS = [];

        if(typeof obj.data == "object")
        {
            PRODUCTS  = obj.data 
            for (var i = 0; i < obj.data.length; i++) 
            {
                mydiv.innerHTML += product_html(obj.data[i], i);
            }
        }  
    }


    document.querySelector(".js-search-items").addEventListener("input",search_item);
    function search_item(e)
    {
        var text = e.target.value.trim();

        obj = {};
        obj.text = text;
        obj.data_type = "search";
        send_data(obj);
    }


    document.querySelector(".js-product-items").addEventListener("click", add_item);
    function add_item(e)
    {
        if(e.target.tagName == "IMG")
        {
            var index = e.target.getAttribute("index");

        for (var i = ITEMS.length - 1; i >= 0; i--) 
        {
            if(ITEMS[i].id == PRODUCTS[index].id)
            {
                ITEMS[i].quantity += 1;
                refresh_items_display();
                return;
            }
        }
           var temp = PRODUCTS[index];
           temp.quantity = 1;

           ITEMS.push(temp)
           refresh_items_display();
        }
        
    }

    function  refresh_items_display()
    {
        var item_count = document.querySelector(".js-item-count");
        item_count.innerHTML = ITEMS.length;

        var item_list_div = document.querySelector(".js-item-list-div");

        item_list_div.innerHTML = "";
        var grand_total = 0;

        for (var i = ITEMS.length - 1; i >= 0; i--) 
        {
             item_list_div.innerHTML += item_html(ITEMS[i],i); 
             grand_total += (ITEMS[i].price * ITEMS[i].quantity);
             GTOTAL = grand_total;
        }

        var gtotal_div = document.querySelector(".js-gtotal");
        gtotal_div.innerHTML = "Total: $" + grand_total.toFixed(2);

    }

    document.querySelector(".js-clear-item").addEventListener("click",clear_all);
    function clear_all(e)
    {
        if(!confirm("Are you sure want to clear all the item in the list"))
            return;

            ITEMS = [];
            refresh_items_display();
    }

    function clear_item(e,index)
    {
        var index = e.currentTarget.getAttribute("index");
 
        if(!confirm("Are you sure want to clear this item from the cart"))
            return;

            ITEMS.splice(index,1);
            refresh_items_display();
    }

    function change_qty(direction,e)
    {
        
        var index = e.currentTarget.getAttribute("index");
        if(direction == "up")
        {
            ITEMS[index].quantity+= 1;
        }else
        if(direction == "down"){

            ITEMS[index].quantity-= 1;

        }else{

            ITEMS[index].quantity = parseInt(e.currentTarget.value);
        }

        if(ITEMS[index].quantity< 1)
        {
            ITEMS[index].quantity= 1;
        }

        refresh_items_display();
    }

    function show_modal(e,modal)
    {
        if(modal == "amount")
        {
            if(ITEMS.length == 0)
            {
                alert("please add at least one item")
                return;
            }
            var mydiv = document.querySelector(".js-amount-paid"); 
            mydiv.classList.remove("hide");

            document.querySelector(".js-amount-input").value = "";
            document.querySelector(".js-amount-input").focus();
        }else
        if(modal == "change")
        {
            var mydiv = document.querySelector(".js-change"); 
            mydiv.classList.remove("hide");

            document.querySelector(".js-show-change").innerHTML = CHANGE;
        }
  
    }

    function hide_modal(e,modal)
    {
        if(e == true || e.target.getAttribute("role") == "close-button")
        {
            if(modal == "amount")
            {
                var mydiv = document.querySelector(".js-amount-paid"); 
                mydiv.classList.add("hide");
            }else
            if(modal == "change")
            {
                var mydiv = document.querySelector(".js-change"); 
                mydiv.classList.add("hide");
            }
        }
    }

    function valdate_amount_paid(e)
    {
        var amount = e.currentTarget.parentNode.querySelector(".js-amount-input").value;
        amount = parseFloat(amount);

        if(!amount)
        {
            alert("Enter a valid amount");
            return;
        }

        if(amount < GTOTAL)
        {
            alert("Amount must be higher or equal to the to al");
            return;
        }

        CHANGE = (amount - GTOTAL);
        CHANGE = CHANGE.toFixed(2);
        ITEMS_NEW = []; 

        for (let i = 0; i < ITEMS.length; i++) {

            ITEMS_NEW.push({
                "product_id": ITEMS[i].product_id,
                "quantity": ITEMS[i].quantity,
                "price": ITEMS[i].price
            });
        }

        hide_modal(true, "amount");
        show_modal(e, "change");

        send_data({
        "data_type": "checkout",
        "text": ITEMS_NEW
        });


        // clear items
        ITEMS = [];
        refresh_items_display();
    }
    
    function item_html(row,index)
    {
            //
        return `           
               <tr>
                    <td style="width: 110px;">
                        <img  src="${row.image}" class="img-fluid rounded border" style="width:100px;height:100px">
                    </td>
                    <td class="text-primary">
                        ${row.product}

                        <div class="input-group my-3" style="width: 120px;">
                            <span index="${index}" onclick=change_qty('down',event) class="input-group-text"><i class="fas fa-minus text-primary" style="cursor: pointer;" ></i></span>
                                <input index="${index}" onblur=change_qty('input',event) type="text" class="form-control" placeholder="1"  value="${row.quantity}">
                            <span index="${index}" onclick=change_qty('up',event) class="input-group-text"><i class="fas fa-plus text-primary" style="cursor: pointer;" ></i></span>
                        </div>
                    </td>
                    <td style="font-size: 20px;">
                        <b>$${row.price}</b>
                        <button index="${index}" onclick="clear_item(event)" class="btn btn-sm btn-outline-danger float-end"><i class="fas fa-times"></i></button>
                    </td>
                </tr>`;
    }

    function product_html(row,index)
    {
            //
        return `<div class="card m-2 border-0" style="max-width: 190px;min-width:190px">
                <a href="#">
                    <img index="${index}" src="${row.image}" class="img-thumbnail w-100 rounded border" alt="">
                </a>
                <div class="p-2">
                    <div class="text-muted">${row.product}</div>
                    <div class="text" style="font-size: 20px;">$${row.price}</div>
                </div>
            </div>`;
    }

    send_data({
        "data_type": "read",
        "text": ""
    });

 </script>