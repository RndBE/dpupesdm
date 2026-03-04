<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chat Bot History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  </head>
  <body>
	  <div class="container my-5">
	  <table class="table table-responsive table-bordered">
		  <thead>
			  <tr>
				  <th>No</th>
				  <th>UUID</th>
				  <th>Jenis</th>
				  <th>Konten</th>
				  <th>Date</th>
			  </tr>
		  </thead>
		  <tbody>
			  <?php foreach ($history as $k=>$v) { ?>
			  <tr>
				  <td><?= $k += 1 ?></td>
				  <td><?= $v['uuid'] ?></td>
				  <td><?= $v['type'] ?></td>
				  <td><?= $v['content'] ?></td>
				  <td class="text-nowrap"><?= $v['date'] ?></td>
			  </tr>
			  <?php } ?>
		  </tbody>
	  </table>
		  </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  </body>
</html>