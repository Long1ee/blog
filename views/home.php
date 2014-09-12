<html>
    <head>
        
    </head>
    <body>
        <h1>Мой блог</h1>
        <table style="width:400px;">
            <thead>
                <tr style="width:400px;">
                    <th>id</th>
                    <th>Title</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($articles as $article): ?>
                <tr>
                    <td><?php echo $article->id ?></td>
                    <td><?php echo $article->title ?></td>
                    <td>
                    <a href="/index.php/blog/edit/<?php echo $article->id ?>">Edit</a>
                    <a href="/index.php/blog/remove/<?php echo $article->id ?>">Remove</a>
                    <a href="/index.php/blog/view/<?php echo $article->slug ?>">View</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </body>
</html>