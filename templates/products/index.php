<!DOCTYPE html>
<style>
.error-flash-message {
    padding: 10px;
    background-color:rgb(175, 76, 76);
    color: white;
    margin-bottom: 15px;
}
.success-flash-message {
    padding: 10px;
    background-color:rgb(106, 175, 76);
    color: white;
    margin-bottom: 15px;
}
</style>
<html>
<head>
    <title>Produtos</title>
</head>
<body>
    <?php if(isset($_SESSION['success-flash-messages'])){ ?> <div class='success-flash-message' > <?php echo $_SESSION['success-flash-messages']; unset($_SESSION['success-flash-messages']); ?></div><?php } ?>
    <?php if (isset($_SESSION['error-flash-messages'])) { ?> <div class='error-flash-message' > <?php echo $_SESSION['error-flash-messages']; unset($_SESSION['error-flash-messages']); ?></div><?php } ?> 
    <h1>Produtos</h1>
    <a href="/produtos/criar">Criar Novo Produto</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['id']); ?></td>
                <td><?= htmlspecialchars($product['name']); ?></td>
                <td><?= htmlspecialchars($product['price']); ?></td>
                <td>
                    <a href="/produtos/exibir?id=<?= $product['id'] ?>">Editar</a>
                    <a href="/produtos/deletar?id=<?= $product['id'] ?>">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div>
        <?php for($i=1; $i < $totalPages; $i++) { ?>
            <a href="/produtos?page=<?= $i ?>"> <?= $i ?></a>
        <?php } ?>
    </div>
</body>
</html>