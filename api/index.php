<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {

    case "GET":

        $path = explode('/', $_SERVER['REQUEST_URI']);

        if ($path[2] === 'products') {

            $sql = "SELECT * FROM products";

            if (isset($path[3]) && is_numeric($path[3])) {
                $sql .= " WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $path[3]);
                $stmt->execute();
                $products = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            echo json_encode($products);
        }
        if ($path[2] === 'orders') {

            $sql = "SELECT * FROM orders";

            if (isset($path[3]) && is_numeric($path[3])) {
                $sql .= " WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $path[3]);
                $stmt->execute();
                $orders = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            echo json_encode($orders);
        }
        if ($path[2] === 'user') {
            if (isset($path[3]) && is_numeric($path[3])) {
                if (isset($path[4]) && ($path[4] === 'orders')) {
                    if (isset($path[5]) && is_numeric($path[5])) {
                        $sql = "SELECT s.id_order, o.date_ord, p.id, p.name, p.image, s.amount, s.total, o.state FROM products p, order_detail s, orders o
                        WHERE p.id = s.id_product AND s.id_order = :id AND o.id = s.id_order";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':id', $path[5]);
                        $stmt->execute();
                        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    } else {
                        $sql = "SELECT o.id AS id_order, o.date_ord, o.state, o.total FROM orders as o where o.id_client = :id ORDER BY o.id DESC";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':id', $path[3]);
                        $stmt->execute();
                        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    }
                    echo json_encode($orders);
                } else {
                    $sql = "SELECT * FROM clients";
                    $sql .= " WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':id', $path[3]);
                    $stmt->execute();
                    $users = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo json_encode($users);
                }
            } else {
                echo json_encode("errore utente non trovato");
            }
            
        }
        if ($path[2] === 'admin') {

            if ($path[3] === 'orders') {
                if (isset($path[4]) && is_numeric($path[4])) {
                    $sql = "SELECT c.id as 'id_client', c.name as 'name_client', c.surname, c.address, c.city, c.telephone, s.id_order, state, date_ord, p.id, p.name, p.image, s.amount, s.total
                    FROM clients c, orders o, products p, order_detail s
                    WHERE o.id_client = c.id
                    AND p.id = s.id_product
                    AND o.id = s.id_order 
                    AND s.id_order = :id ";

                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':id', $path[4]);
                    $stmt->execute();
                    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $sql = "SELECT o.id as 'id_order', c.id, name, surname, state, date_ord, total
                      FROM clients c, orders o
                      WHERE o.id_client = c.id
                      ORDER BY date_ord DESC";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            } else {
                echo json_encode("errore utente non trovato");
            }
            echo json_encode($orders);
        }

        break;
    case "POST":
        $input = json_decode(file_get_contents('php://input'));

        $path = explode('/', $_SERVER['REQUEST_URI']);
        if ($path[2] === 'products') {

            if ($path[3] === 'order') {

                $sql = "INSERT INTO orders(id, id_client, date_ord, state, total)
                        VALUES(null, :id_client, :date_ord, :state, :total)";

                $stmt = $conn->prepare($sql);

                $id_client = $input->id_client;
                $data = date("Y-m-d H:i:s");
                $state = "attesa di conferma";
                $stmt->bindParam(':id_client', $id_client);
                $stmt->bindParam(':date_ord', $data);
                $stmt->bindParam(':state', $state);
                $stmt->bindParam(':total', $input->cart_total);
                $rst = $stmt->execute();

                $objDb2 = new DbConnect;
                $conn2 = $objDb2->connect();
                $sql2 = 'SELECT id AS id_order FROM orders WHERE id_client = :id_client AND date_ord = (SELECT MAX(date_ord) FROM orders WHERE id_client = :id_client) ';

                $stmt2 = $conn2->prepare($sql2);
                $stmt2->bindParam(':id_client', $id_client);
                $stmt2->execute();
                $id_order = $stmt2->fetch(PDO::FETCH_ASSOC);

                $prodotti = $input->products;

                foreach ($prodotti as $prodotto) {

                    $objDb4 = new DbConnect;
                    $conn4 = $objDb4->connect();

                    $sql4 = "INSERT INTO order_detail (id_order, id_product, amount, total)
                             VALUES(:id_order, :id_product, :amount, :total)";

                    $stmt4 = $conn4->prepare($sql4);
                    $total = ($prodotto->quantity * $prodotto->price);
                    $stmt4->bindParam(':id_order', $id_order["id_order"]);
                    $stmt4->bindParam(':id_product', $prodotto->id);
                    $stmt4->bindParam(':amount', $prodotto->quantity);
                    $stmt4->bindParam(':total', $total);
                    $rst3 = $stmt4->execute();
                }
                echo json_encode($id_order);
            }
            if ($path[3] === 'save') {

                $sql = "INSERT INTO products(id, name, price, description, image, id_category)
                        VALUES(null, :name, :price, :description, :image, :id_category)";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':name', $input->name);
                $stmt->bindParam(':price', $input->price);
                $stmt->bindParam(':description', $input->description);
                $stmt->bindParam(':image', $input->image);
                $stmt->bindParam(':id_category', $input->id_category);

                if ($stmt->execute()) {
                    $response = ['status' => 1, 'message' => 'Record created successfully.'];
                } else {
                    $response = ['status' => 0, 'message' => 'Failed to create record.'];
                }
                echo json_encode($response);
            }
            if ($path[3] === 'filter') {

                $sql = "SELECT p.id, p.name, p.price, p.description, p.image FROM products p, category c
                        WHERE p.id_category = c.id";
                $var = 0;

                if ($input->Bianca) {
                    $sql .= " AND (c.name = 'Carne Bianca'";
                    $var++;
                }
                if ($input->Rossa) {
                    if ($var > 0) $sql .= " OR";
                    else {
                        $sql .= " AND (";
                        $var++;
                    }
                    $sql .= " c.name = 'Carne Rossa'";
                }
                if ($input->Preparati) {
                    if ($var > 0) $sql .= " OR";
                    else {
                        $sql .= " AND (";
                        $var++;
                    }
                    $sql .= " c.name = 'Preparati'";
                }
                $sql .= ")";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

                echo json_encode($products);
            }
        }

        if ($path[2] === 'user') {

            if ($path[3] === 'login') {
                $sql = "SELECT * FROM clients";
                $sql .= " WHERE email = :email ";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':email', $input->email);
                $stmt->execute();
                $usr = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode($usr);
            }

            if ($path[3] === 'save') {

                $sql = "INSERT INTO clients(id, name, surname, email, password, address, city, telephone)
                        VALUES(null, :name, :surname, :email, :password, :address, :city, :telephone)";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':name', $input->name);
                $stmt->bindParam(':surname', $input->surname);
                $stmt->bindParam(':email', $input->email);
                $stmt->bindParam(':password', $input->password);
                $stmt->bindParam(':address', $input->address);
                $stmt->bindParam(':city', $input->city);
                $stmt->bindParam(':telephone', $input->telephone);

                if ($stmt->execute()) {
                    $response = ['status' => 1, 'message' => 'Record created successfully.'];
                } else {
                    $response = ['status' => 0, 'message' => 'Failed to create record.'];
                }
                echo json_encode($response);
            }
        }

        break;

    case "PUT":
        $input = json_decode(file_get_contents('php://input'));
        $path = explode('/', $_SERVER['REQUEST_URI']);

        if ($path[2] === 'user') {
            if (isset($path[3]) && is_numeric($path[3]) && isset($path[4]) && ($path[4] === 'edit')) {
                $sql = "UPDATE clients
                        SET name= :name, surname = :surname, address = :address, city= :city, email =:email, password= :password, telephone =:telephone WHERE clients.id = :id";
                $stmt = $conn->prepare($sql);

                $stmt->bindParam(':id', $input->id);
                $stmt->bindParam(':name', $input->name);
                $stmt->bindParam(':surname', $input->surname);
                $stmt->bindParam(':address', $input->address);
                $stmt->bindParam(':city', $input->city);
                $stmt->bindParam(':email', $input->email);
                $stmt->bindParam(':password', $input->password);
                $stmt->bindParam(':telephone', $input->telephone);

                if ($stmt->execute()) {
                    $response = ['status' => 1, 'message' => 'Record updated successfully.'];
                } else {
                    $response = ['status' => 0, 'message' => 'Failed to update record.'];
                }
                echo json_encode($response);
            }
        }
        if ($path[2] === 'product') {

            if (isset($path[3]) && is_numeric($path[3]) && isset($path[4]) && ($path[4] === 'edit')) {

                $sql = "UPDATE products
                        SET name= :name, price = :price, description= :description, image =:image, id_category =:id_category WHERE products.id = :id";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $path[3]);
                $stmt->bindParam(':name', $input->name);
                $stmt->bindParam(':price', $input->price);
                $stmt->bindParam(':description', $input->description);
                $stmt->bindParam(':image', $input->image);
                $stmt->bindParam(':id_category', $input->id_category);

                if ($stmt->execute()) {
                    $response = ['status' => 1, 'message' => 'Record updated successfully.'];
                } else {
                    $response = ['status' => 0, 'message' => 'Failed to update record.'];
                }
                echo json_encode($response);
            }
        }

        if ($path[2] === 'order_state') {

            if (isset($path[3]) && is_numeric($path[3])) {

                $sql = "UPDATE orders
                        SET state= :state WHERE orders.id = :id";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $path[3]);

                if ($input === 1) {
                    $stmt->bindValue(':state', "in preparazione", PDO::PARAM_STR);
                } else if ($input === 2) {
                    $stmt->bindValue(':state', "in consegna", PDO::PARAM_STR);
                } else if ($input === 3) {
                    $stmt->bindValue(':state', "consegnato", PDO::PARAM_STR);
                }

                if ($stmt->execute()) {
                    $response = ['status' => 1, 'message' => 'State updated successfully.'];
                } else {
                    $response = ['status' => 0, 'message' => 'Failed to update state.'];
                }
                echo json_encode($response);
            }
        }

        break;

    case "DELETE":
        
        $path = explode('/', $_SERVER['REQUEST_URI']);

        if ($path[2] === 'products') {

            $sql = "DELETE FROM products WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $path[3]);

            if ($stmt->execute()) {
                $response = ['status' => 1, 'message' => 'Record deleted successfully.'];
            } else {
                $response = ['status' => 0, 'message' => 'Failed to delete record.'];
            }
            echo json_encode($response);
            break;
        }
}
