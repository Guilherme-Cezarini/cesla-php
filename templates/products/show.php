
<style>
.error-flash-message {
    padding: 10px;
    background-color:rgb(175, 76, 76);
    color: white;
    margin-bottom: 15px;
}
</style>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edição de produtos</title>

    </head>
    <body>
        <?php if (isset($errors)) { ?> <div class='error-flash-message' > <?php for ($i=0; $i < count($errors); $i++) { echo $errors[$i]; } ?> </div><?php } ?>        
        <a href="/produtos">Voltar</a>
        <h2>Edição de produtos </h2>
        <form action="/produtos/editar" method="POST">
            <label for="name">Nome: </label>
            <input type="text" name="name" required value= "<?php if (isset($product['name'])){ echo htmlspecialchars($product['name']);  }?>">
            
            <label for="description">Descrição: </label>
            <input type="text" name="description" value= "<?php if (isset($product['description'])){ echo htmlspecialchars($product['description']);  }?>">

            <label for="price">Preço: </label>
            <input type="number" name="price" required value= "<?php if (isset($product['price'])){ echo htmlspecialchars($product['price']);  }?>"> 

            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="id" value="<?= $product['id']; ?>">
            <input type="submit" value="Editar">
        </form>
    </body>
</html>