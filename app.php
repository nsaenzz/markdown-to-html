<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body class="h-full">
<div class="m-2 row">
    <div class="col">
        <p>White Markdown text:</p>
        <form action="" method="POST">
            <textarea
            class="
                form-control
                block w-full
                px-3 py-1.5
                text-base 
                font-normal
                text-gray-700
                bg-white bg-clip-padding
                border border-solid border-gray-300
                rounded
                transition
                ease-in-out
                m-0 mt-2
                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none
            "
            id="markdowntext" name="markdowntext" style="height:75vh"
            spellcheck="false" autofocus="autofocus"
            placeholder="Markdown Text"
            ><?php if(isset($_POST['markdowntext'])) 
                echo trim($_POST['markdowntext']);
            ?></textarea>
            <button type="submit" name="submit"
                class="btn btn-primary inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight mt-5
                    uppercase rounded-full shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg 
                    focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                    Parse
            </button>
        </form>
        
    </div>
  
    <div class="col">
        <p>Result:</p>
        <?php
            $htmlConverted = "";
            if(isset($_POST['submit'])){
                require_once 'Markdown.php';
                $markdown = new Markdown();
                $htmlConverted = $markdown->text($_POST['markdowntext']);
            }
            print_r($htmlConverted);
        ?>
    </div>
</div>
</body>