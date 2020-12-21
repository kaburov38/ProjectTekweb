<?php
    include "../services/database.php";
    if(!isset($_SESSION['usernametoko']))
    {
        header("Location: index.php");
        exit();
    } 
    $username = $_SESSION['usernametoko'];
?>
<html>
    <head>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
        <script src="https://use.fontawesome.com/504410ced2.js"></script>
        <link rel="stylesheet" href="../css/home.css">
        <link rel="stylesheet" href="https://cdnjs.cloud
        flare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script>
            function Confirm(id)
            {
                $.ajax({
                    url: "../services/confirmitem-toko.php",
                    method: "POST",
                    data: {
                        id: id
                    },
                    success: function(res){
                        console.log(res);
                        if(res == "success")
                        {
                            alert("Item berhasil confirm");
                            History();
                        }
                        else
                        {
                            alert("Try again");
                        }
                    }
                })
            }
            function Cancel(id)
            {
                $.ajax({
                    url: "../services/cancelitem-toko.php",
                    method: "POST",
                    data: {
                        id: id,
                    },
                    success: function(res){
                        console.log(res);
                        if(res == "success")
                        {
                            alert("Item dicancel");
                            History();
                        }
                        else
                        {
                            alert("Try Again");
                        }
                    }
                    
                });
            }  
            function History()
            {
                var pembeli = $("#pembeli").val();
                $.ajax({
                    url: "../services/viewsales-toko.php",
                    method: "POST",
                    data: {
                        usernametoko: pembeli
                    },
                    success: function(res){
                        console.log(res);
                         $("#item-list").html('');
                         var table = $("<table class='table table-striped'></table>");
                         var title = $(`<thead class='thead-dark'><tr>
                                        <td>Id Pembelian</td>
                                        <td>Tanggal Pembelian</td>
                                        <td>jumlah barang</td>
                                        <td>Nama Pembeli</td>
                                        <td>Harga</td>
                                        <td colspan="2" style="text-align: center">Status</td>
                                        </tr></thead>`);
                         table.append(title);
                         res.forEach(function(item){
                            var html = $(`
                                <tr>
                                <td>`+ item['id_pembelian'] +`</td>
                                <td>` + item['tanggal'] + `</td>
                                <td>` + item['jumlah'] + `</td>
                                <td>` + item['username'] + `</td>
                                <td>` + item['harga'] + `</td>
                                <td><a class="btn btn-success" onclick="Confirm(` + item['id_detail'] + `)">Confirm</a></td>
                                <td><a class="btn btn-danger" onclick="Cancel(` + item['id_detail'] + `)">Cancel</a></td>
                                </tr>
                            `)                           
                            table.append(html);
                         });
                         $("#item-list").append(table);
                    }
                });
            }         
            function LogOut()
            {
                $.ajax({
                    url: "../services/logout.php",
                    method: "GET",
                    success: function(res){
                        if(res == "logout"){
                            location.reload();
                        }
                    }
                })
            }
        </script>
    </head>
    <body onload="History()">
        <?php include "navbar.php"; ?>
        <div class="container">           
            <input type="hidden" id="pembeli" value="<?php echo $username; ?>"></input>
            <div class="transparenttable">
                <div id="item-list" class="item-list">

                </div>
            </div>            
        </div>
    </body>
</html>