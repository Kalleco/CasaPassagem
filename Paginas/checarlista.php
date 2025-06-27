<?php
require '../Formularios/processo.php';

$pesquisa = $_GET['nome'] ?? '';

if($pesquisa){
  $stmt = $db->prepare("SELECT h.id AS hospedagens, h.banho, h.jantou, h.passagem, h.destino, h.atendente,
m.id AS morador_id, m.nome, m.data_nasc, m.rg, m.cpf, m.cidade_origem, m.beneficio, h.data_checkin, h.data_checkout
FROM moradores m
JOIN hospedagens h on m.id = h.morador_id
WHERE h.data_checkout IS NOT NULL and m.nome LIKE ?");
  $stmt->execute(["%$pesquisa%"]);
}
else{
$stmt = $db->prepare("SELECT h.id AS hospedagens, h.banho, h.jantou, h.passagem, h.destino, h.atendente,
m.id AS morador_id, m.nome, m.data_nasc, m.rg, m.cpf, m.cidade_origem, m.beneficio, h.data_checkin, h.data_checkout
FROM moradores m
JOIN hospedagens h on m.id = h.morador_id
WHERE h.data_checkout IS NOT NULL");
$stmt->execute();
}

$moradores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casa de passagem</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/home.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  </head>
    <body>
 <nav id="navbar">
  <img src="https://www.aparecida.sp.gov.br/img/logo_rodape.png" class="img-fluid " alt="Logo">   
   <ul id="nav_list">
        <li class="nav-item">
            <i class="fa-solid fa-house"></i>
          <a href="/Paginas/index.php">Dashboard</a>
          </li>
            <li class="nav-item active">
          <i class="fa-solid fa-house"></i>
          <a href="/Paginas/checarlista.php">Histórico</a>
          </li>
            <li class="nav-item">
          <i class="fa-solid fa-book-open"></i>
          <a href="/Paginas/lista.php">Check-in</a>
          </li>
          <li class="nav-item">
            <i class="fa-solid fa-list"></i>
          <a href="/Paginas/fazcheckin.php">Lista de moradores</a>
          </li>
          
      </ul>

      <button class ="btn btn-default">
          Cadastro
      </button>
     </nav> 
  </header>

  <main id="content">

        <div class="container pt-3">
        <h1>Histórico</h1>
        <form method="get" action="">
          <div class="input-group">
          <input type="text" class="form-control" placeholder="Pesquise pelo nome" name="nome" value=<?php echo htmlspecialchars($pesquisa);?>>
          <button class="btn btn-primary" type="submit">Buscar</button>
          </div>
        </form><br>
        <?php if (count($moradores) > 0): ?>
            
        <table class="table table-bordered table-sm table-responsive">
            <tr>
                <th>Nome:</th>
                <th>Data Nasc:</th>
                <th>Cidade Origem:</th>
                <th>Beneficio:</th>
                <th>Check-in:</th>
                <th>Check-out:</th>
                <th>Banho:</th>
                <th>Jantou:</th>
                <th>Passagem:</th>
                <th>Destino:</th>
                <th>Atendente:</th>
            </tr>
            <?php foreach ($moradores as $m): ?>
                <tr>
                <td><?php echo ($m['nome'])?></td>
                <td><?php echo ($m['data_nasc'])?></td>
                <td><?php echo ($m['cidade_origem'])?></td>
                <td><?php echo ($m['beneficio'])?></td>
                <td><?php echo ($m['data_checkin'])?></td>
                <td><?php echo ($m['data_checkout'])?></td>
                <td><?php echo ($m['banho'])?></td>
                <td><?php echo ($m['jantou'])?></td>
                <td><?php echo ($m['passagem'])?></td>
                <td><?php echo ($m['destino'])?></td>
                <td><?php echo ($m['atendente'])?></td>
                </tr>
            <?php endforeach; ?>
        </table>  
        <button onclick="exportarTabelaExcel()" class="btn btn-primary">Exportar para excel</button>
        </div>
        </div>
        </div>
        </div>
        <?php else: ?>
          <p>Não foi efetuado nenhum check-out!</p>
        <?php endif; ?>
        </main>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">      
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

        <script> //para exportar tabela
        function exportarTabelaExcel() {
            // Seleciona a tabela do HTML
            const tabela = document.querySelector("table");

            // Converte para planilha
            const workbook = XLSX.utils.table_to_book(tabela, { sheet: "Histórico" });

            // Salva o arquivo
            XLSX.writeFile(workbook, "histórico.xlsx");
        }
        </script>

    </body>
    </html>