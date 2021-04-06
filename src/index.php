<?php 

use Models\Product;

require_once "../bootstrap.php";

// Helper functions
function redirect_to_root(){
    header("Location: " . parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
}

// Add new product
if(isset($_GET['name'])){
    $product = new Product();
    $product->setName($_GET['name']);
    $entityManager->persist($product);
    $entityManager->flush();
    redirect_to_root();
}

// Delete product
if(isset($_GET['delete'])){
    $user = $entityManager->find('Models\Product', $_GET['delete']);
    $entityManager->remove($user);
    $entityManager->flush();
    redirect_to_root();
}

// Update
if(isset($_POST['update_name'])){
    $user = $entityManager->find('Models\Product', $_POST['update_id']);
    $user->setName($_POST['update_name']);
    $entityManager->flush();
    redirect_to_root();
}

print("<pre>Find Product by id: " . "<br>");
// $product = $entityManager->find('Product', 3);
// ... SELECT + WHERE ID
$product = $entityManager->find('Models\Product', 2); // jei naudojame namespaceus
$product !== NULL ? print $product->getId() . ' ' . $product->getName() : '';
print("</pre><hr>");


// print("<pre>Find Product(s) by other property (name): " . "<br>");
// // ... SELECT + WHERE Name
// $products = $entityManager->getRepository('Models\Product')->findBy(array('name' => 'Batukai'));
// $products[0] !== NULL ? print $products[0]->getId() . ' ' . $products[0]->getName() : '';
// print("</pre><hr>");

print("<pre>Find Product(s) by other property (name): " . "<br>");
$products = $entityManager->getRepository('Models\Product')->findBy(array('name' => 'Doe'));
print("<table>");
foreach($products as $p)
    print("<tr>" 
            . "<td>" . $p->getId()  . "</td>" 
            . "<td>" . $p->getName() . "</td>" 
            . "<td><a href=\"?delete={$p->getId()}\">DELETE</a></td>" 
            . "<td><a href=\"?updatable={$p->getId()}\">UPDATE</a></td>"
        . "</tr>");
print("</table>"); 
print("</pre><hr>");

print("<pre>Find Product(s) by other property (name) sorted by another property (id): " . "<br>");
$products = $entityManager
    ->getRepository('Models\Product')
    ->findBy(array('name' => 'Doe'), array('id' => 'DESC'));
print("<table>");
foreach($products as $p)
    print("<tr>" 
            . "<td>" . $p->getId()  . "</td>" 
            . "<td>" . $p->getName() . "</td>" 
            . "<td><a href=\"?delete={$p->getId()}\">DELETE</a></td>" 
            . "<td><a href=\"?updatable={$p->getId()}\">UPDATE</a></td>"
        . "</tr>");
print("</table>"); 
print("</pre><hr>");

print("<pre>Find all Products: " . "<br>");
$products = $entityManager->getRepository('Models\Product')->findAll();
print("<table>");
foreach($products as $p)
    print("<tr>" 
            . "<td>" . $p->getId()  . "</td>" 
            . "<td>" . $p->getName() . "</td>" 
            . "<td><a href=\"?delete={$p->getId()}\">DELETE</a>☢️</td>" 
            . "<td><a href=\"?updatable={$p->getId()}\">UPDATE</a>♻️</td>"
        . "</tr>");
print("</table>"); 
print("</pre><hr>");

if(isset($_GET['updatable'])){
    $product = $entityManager->find('Models\Product', $_GET['updatable']);
    print("<pre>Update Product: </pre>");
    print("
        <form action=\"\" method=\"POST\">
            <input type=\"hidden\" name=\"update_id\" value=\"{$product->getId()}\">
            <label for=\"name\">Product name: </label><br>
            <input type=\"text\" name=\"update_name\" value=\"{$product->getName()}\"><br>
            <input type=\"submit\" value=\"Submit\">
        </form>
    ");
    print("<hr>");
}

print("<pre>Add new product: " . "</pre>");
?>
<form action="" method="GET">
  <label for="name">Product name: </label><br>
  <input type="text" name="name" value="Doe"><br>
  <input type="submit" value="Submit">
</form> 
<hr>

