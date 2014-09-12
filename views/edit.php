<html>
    <head>
        
    </head>
    <body>
        <h1>Мой блог</h1>
        <h2>Добавить новую статью</h2>
        <form method="post" action="/index.php/blog/edit/<?php echo $article->id; ?>">
            <label>title</label>
            <input type="text" name="title" 
            value="<?php echo $article->title ?>" /><br />
            <label>text</label>
            <textarea name="body"><?php echo $article->body; ?></textarea><br />
            <input type="submit" />
        </form>
    </body>
</html>