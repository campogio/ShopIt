<?php

    require "dbms.inc.php";
    
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    
    
    function insertImage($filepath){
        global $mysqli;
        
        $sql= "INSERT INTO image(path) VALUES ('$filepath')";
        
        echo $sql;
        
        $result = $mysqli->query($sql);
        
        return $mysqli->insert_id;
    }
    
    function getCartForUser($userId)
    {
        global $mysqli;
        
        $sql = "SELECT cart_id,products_id,quantity,name,price,saleprice,path FROM cart_has_products
                LEFT JOIN cart ON cart.id = cart_has_products.cart_id
                LEFT JOIN products ON products.id=cart_has_products.products_id
                LEFT JOIN image ON products.image_id = image.id
                WHERE cart.user_id = ".$userId.";";
        
        $result = $mysqli->query($sql);
        
        return $result;
        
    }
    
    function getUserWishlist($userId){
        
        global $mysqli;
        
        $sql = "SELECT * FROM wishlist WHERE user_id =".$userId;
        
        $wishlist = $mysqli->query($sql);
        $wishlistId = 0;
        if($wishlist->num_rows == 0){
            $mysqli->query("INSERT INTO wishlist (user_id) VALUES (".$userId.")");
            
            $wishlistId= $mysqli->insert_id;
        }else{
            while ($data = $wishlist->fetch_assoc()){
                
                echo json_encode($data);
                
                $wishlistId = $data['id'];
            }
        }
        
        
        $sql = "SELECT * FROM wishlist_has_products
                LEFT JOIN wishlist ON wishlist.id = wishlist_has_products.wishlist_id
                LEFT JOIN products ON products.id = wishlist_has_products.products_id
                LEFT JOIN image ON image.id = products.image_id WHERE wishlist.id = ". $wishlistId;
        
        $result = $mysqli->query($sql);
        
        return $result;
        
    }
    
    function removeFromWishlist($itemId,$userId){
    
    }
    
    function addToWishlist($itemId,$userId){
    
        global $mysqli;
        
        $wishlist= $mysqli->query("SELECT * FROM wishlist WHERE user_id =".$userId);
        $wishlistId=0;
        
        if($wishlist->num_rows == 0){
            $mysqli->query("INSERT INTO wishlist (user_id) VALUES (".$userId.")");
            
            $wishlistId= $mysqli->insert_id;
        }else{
            while ($data = $wishlist->fetch_assoc()){
                
                echo json_encode($data);
                
                $wishlistId = $data['id'];
            }
        }
        
        $sql= "REPLACE INTO wishlist_has_products(wishlist_id,products_id) VALUES (".$wishlistId.",".$itemId.")";
        
        $mysqli->query($sql);
        
    }
    
    function getOrderProducts($orderId){
    
        global $mysqli;
        
        $sql = "SELECT * FROM order_has_products
                LEFT JOIN user_has_order ON order_has_products.order_id = user_has_order.order_id
                LEFT JOIN products ON order_has_products.products_id = products.id
                LEFT JOIN image ON products.image_id = image.id
                WHERE order_has_products.order_id = ".$orderId.";";
        $result=$mysqli->query($sql);
        
        return $result;
    }
    
    function getUserOrders($userId){
        global $mysqli;
        
        $sql = "SELECT * FROM mydb.order LEFT JOIN user_has_order ON user_has_order.order_id = mydb.order.id WHERE user_id = ".$userId;
        
        $result= $mysqli->query($sql);
        
        return $result;
    }
    
    function postOrder($userId,$orderInfo,$products,$total){
        
        global $mysqli;
        
        $date = date("Y-m-d");
        
        if($orderInfo['phone'] == ""){
            $sql = "INSERT INTO mydb.order(name,surname,street,city,zipcode,state,email,date,total,orderstate)
                VALUES ('".$orderInfo['firstname']."','".$orderInfo['lastname']."','".$orderInfo['street']."','".$orderInfo['city']."',
                        '".$orderInfo['zip']."','".$orderInfo['state']."','".$orderInfo['email']."','".$date."',".$total.",0)";
        }else{
            
            $sql = "INSERT INTO mydb.order(name,surname,street,city,zipcode,state,telephone,email,date,total,orderstate)
                VALUES ('".$orderInfo['firstname']."','".$orderInfo['lastname']."','".$orderInfo['street']."','".$orderInfo['city']."',
                        '".$orderInfo['zip']."','".$orderInfo['state']."','".$orderInfo['phone']."','".$orderInfo['email']."','".$date."',".$total.",0)";
        }
        
        echo $sql;
        
        $mysqli->query($sql);
        
        $id = $mysqli->insert_id;
        
        $sql = "INSERT INTO user_has_order VALUES (".$userId.",".$id.")";
        
        $mysqli->query($sql);
        
        $cartId = 0;
        
        while($data = $products->fetch_assoc()){
            
            $cartId = $data['cart_id'];
            
            if($data['saleprice']==null OR $data['saleprice']==''){
                $sql = "INSERT INTO order_has_products VALUES (".$id.",".$data['products_id'].",".$data['quantity'].",".$data['price'].",0)";
            }else{
                $sql = "INSERT INTO order_has_products VALUES (".$id.",".$data['products_id'].",".$data['quantity'].",".$data['saleprice'].",0)";
            }
            $mysqli->query($sql);
            
        }
        
        $sql = "DELETE FROM cart_has_products WHERE cart_id =".$cartId;
        
        echo $sql;
        
        $mysqli->query($sql);
        
        
        
    }
    
    function removeFromCart($userId,$productId){
        global $mysqli;
        
        $sql = "SELECT * FROM cart WHERE user_id =".$userId;
        echo $sql;
        $res =$mysqli->query($sql);
        $id = 0;
        
        while ($data = $res->fetch_assoc()){
            $id = $data['id'];
        }
        
        $sql = "DELETE FROM cart_has_products WHERE cart_id = ".$id." AND products_id = " .$productId ."; ";
        
        echo $sql;
        
        $mysqli->query($sql);
    }
    
    function addToCart($itemId,$userId,$quantity){
        global $mysqli;
        
        $cart= $mysqli->query("SELECT * FROM cart WHERE user_id =".$userId);
        $cartId=0;
        
        if($cart->num_rows == 0){
            $mysqli->query("INSERT INTO cart (user_id) VALUES (".$userId.")");
            
            $cartId= $mysqli->insert_id;
        }else{
        
            while ($data = $cart->fetch_assoc()){
                
                echo json_encode($data);
                
                $cartId = $data['id'];
            }
        
        }
        
        $sql= "REPLACE INTO cart_has_products(cart_id,products_id,quantity) VALUES (".$cartId.",".$itemId.",".$quantity.")";
        
        $mysqli->query($sql);
    }
    
    function insertProduct($userid,$name,$price,$saleprice,$brand,$category,$showcaseid,$imagesids)
    {
        global $mysqli;
        $sql = "";
        
        $date = date("Y-m-d");

        if($saleprice != ""){
            $sql = "INSERT INTO products(user_id,name,price,saleprice,brand_id,category_id,image_id,added) VALUES (".$userid.",'".$name."',".$price.",".$saleprice.",".$brand.",".$category.",".$showcaseid.",'".$date."')";
        }else{
            $sql = "INSERT INTO products(user_id,name,price,brand_id,category_id,image_id,added) VALUES (".$userid.",'".$name."',".$price.",".$brand.",".$category.",".$showcaseid.",'".$date."')";
        }
        
        echo $sql;
        
        $mysqli->query($sql);
        
        $itemid = $mysqli->insert_id;
        
        $sql = "INSERT INTO products_has_image VALUES (".$itemid.",".$showcaseid.")";
        
        $mysqli->query($sql);
        
        foreach ($imagesids as $image){
            $sql = "INSERT INTO products_has_image VALUES (".$itemid.",".$image.")";
            
            $mysqli->query($sql);
        }
    }
    
    function testInsert(){
        
        global $mysqli;
        $result = $mysqli->query("INSERT INTO user(username,password) VALUES('username','userpass');");
        
        echo "ID THE QUERY WAS ADDED TO: ". $mysqli->insert_id;
        
    }
    
    function exists($table,$columns,$params){
        
        global $mysqli;
        
        $sql = "SELECT * FROM $table WHERE ";
        
        if($columns[0]=="id"){
            $sql = $sql . "id = " . $params[0];
            
            $result = $mysqli ->query($sql);
            
            if($result->num_rows>0){
                return true;
            }else{
                return false;
            }
            
        }else{
            return false;
        }
    }
    
    function getTables(){
        
        global $mysqli;
        $result= $mysqli->query("SHOW TABLES");
        return $result;
        
    }
    
    function getProductsByCategory($category,$amount,$offset){
    
        global $mysqli;
        $result= $mysqli->query("SELECT products.*,image.path,category.name AS 'categoryname' FROM products
                                        JOIN category ON products.category_id = category.id
                                        JOIN image ON products.image_id = image.id
                                        WHERE category.name ='$category' LIMIT $amount OFFSET $offset");
        
        return $result;
        
    }
    
    function getProductById($id){
    
        global $mysqli;
        $result= $mysqli->query("SELECT products.*,category.name AS 'categoryname' FROM products
                                    JOIN category ON products.category_id = category.id WHERE products.id= $id");
        
        return $result;
    }
    
    function getImagesForProduct($id){
        
        global $mysqli;
        
        $result = $mysqli->query("SELECT image.id,image.path FROM products_has_image
                                        RIGHT JOIN image ON products_has_image.image_id= image.id WHERE products_id = $id;");
        
        return $result;
        
    }
    
    function getTableColumns($table){
        
        global $mysqli;
        $stmt = $mysqli->prepare("SELECT COLUMN_NAME
                                        FROM INFORMATION_SCHEMA.COLUMNS
                                        WHERE TABLE_SCHEMA = 'mydb' AND TABLE_NAME = ?;");
        
        $stmt->bind_param("s",$table);
        
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        return $result;
        
    }
    
    function getTableData($table){
        
        //Needs a whitelist of tables to make sure of no SQL Injections, it's not possible to parametrize a table name
        
        global $mysqli;
        $result = $mysqli->query("SELECT * FROM ".$table);
        return $result;
        
    }
    
    function removeTableData($table,$columns,$params){
        
        global $mysqli;
        
        $sql = "DELETE FROM $table WHERE ";
        
        for($i=0;$i<count($columns);$i++){
            
            if(($i+1) == count($columns)){
                $sql = $sql . $columns[$i] . " = ?";
            }else{
                $sql = $sql . $columns[$i] . " = ? AND ";
            }
        }
        
        echo $sql;
        
        $mysqli->prepare($sql);
        
        $result = $mysqli->execute_query($sql,$params);
        
        return $result;
        
    }
    
    function insertTableData($table,$columns,$params){
        
        global $mysqli;
        
        if(exists($table,$columns,$params)){
            $sql = "UPDATE $table SET "; // sql
            
            
            //Starting from 1 cause ID can't be changed
            for($i=1;$i<count($columns);$i++){
                $sql = $sql . $columns[$i] . " = '" . $params[$i] . "',";
            }
            
            $sql= rtrim($sql,",");
            
            $sql = $sql . " WHERE id = " . $params[0];
            
            $result = $mysqli->execute_query($sql);
            
        }else{
            $parameters = str_repeat('?,', count($params) - 1) . '?';
            $sql = "INSERT INTO $table("; // sql
            
            foreach ($columns as $col){
                $sql= $sql . $col . ",";
            }
            
            $sql= rtrim($sql,",");
            
            $sql= $sql . " ) VALUES($parameters)";
            
            $result = $mysqli->execute_query($sql,$params);
        }
        
        echo $sql;
        
        return $result;
        
        
    }

    function getUser($mysqli,$user,$pass){

    $stmt = $mysqli->prepare("SELECT * FROM user WHERE username = ? AND password = ?");

    /* bind parameters for markers */
    $stmt->bind_param("ss",$user, $pass);

    /* execute query */
    $stmt->execute();

    $result = $stmt->get_result();

    return $result;
}


?>
