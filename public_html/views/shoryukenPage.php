<h1>Street Fighter 5</h1>
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Score</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $test = $data['SF5'];
    //var_dump($test);
    foreach ($test as $result) {
      //var_dump($result->entry);
      echo '<tr class="table-active">
        <td>'.$result->entry[0].'</td>
        <td>'.$result->entry[5].'</td>
      </tr>';

    }
    ?>
  </tbody>
</table> 

<br>

<h1>Mortal Kombat X</h1>
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Score</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $test = $data['MKX'];
    //var_dump($test);
    foreach ($test as $result) {
      //var_dump($result->entry);
      echo '<tr class="table-active">
        <td>'.$result->entry[0].'</td>
        <td>'.$result->entry[5].'</td>
      </tr>';

    }
    ?>
  </tbody>
</table> 
<br>

<h1>Ultimate Marvel vs. Capcom 3</h1>
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Score</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $test = $data['UMVC3'];
    //var_dump($test);
    foreach ($test as $result) {
      //var_dump($result->entry);
      echo '<tr class="table-active">
        <td>'.$result->entry[0].'</td>
        <td>'.$result->entry[5].'</td>
      </tr>';

    }
    ?>
  </tbody>
</table> 