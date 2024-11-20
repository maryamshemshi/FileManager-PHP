<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Manager</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        ul {
            color: white;
            margin-right: 50px;
        }

        body {
            background-color: lightskyblue;
            background-size: contain;
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            margin: 0;
        }

        ul li {
            font-size: 20px;
            display: flex;
            align-items: center;
        }

        i.fa.fa-trash {
            margin-left: 20px;
        }

        i.fa.fa-edit {
            margin-left: 10px;
            margin-top: 20px;
        }

        .input-group {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        input#inputGroupFile02 {
            height: 100px;
            width: 100%;
        }

        input {
            height: 40px;
            max-width: 25%;
            margin-right: 10px;
            flex: 1;
            margin-left: 30px;
        }

        button {
            height: 40px;
            max-width: 100%;
        }

        .folder {
            color: rgb(220, 165, 40);
            font-style: oblique;
            align-items: baseline;
        }

        form {
            margin-top: 20px;
        }

        .file {
            font-style: italic;
            font-weight: initial;
            display: flex;
            align-items: baseline;
        }
    </style>
</head>
<body>
<a class="btn btn-primary" href="index.php" role="button" style="width:10%; position:absolute; left:1370px; top:15px;">Home</a>

<ul>
    <?php
    include_once 'removefile.php';
    if (isset($_REQUEST['address'])) {
        $current_dir = $_REQUEST['address'];
    } else {
        $current_dir = __DIR__ . '/files';
    }

    if (isset($_REQUEST['delete'])) {
        if (file_exists($_REQUEST['delete'])) {
            $dir = $_REQUEST['delete'];
            if (is_dir($_REQUEST['delete'])) {
                myRemoveDir($dir);
            } else {
                unlink($dir);
            }
        }
    }

    if (isset($_REQUEST['edit'])) { ?>
        <form action="" method="get">
            <input type="hidden" name="oldName" value="<?php echo $_REQUEST['edit']; ?>">
            <input type="hidden" name="address" value="<?php echo $current_dir; ?>">
            <input type="text" name="newName" value="<?php echo $_REQUEST['name']; ?>">
            <input type="submit" value="Editname">
        </form>

    <?php }
    if (isset($_REQUEST['oldName'])) {
        $oldNamePath = $_REQUEST['oldName'];
        $newNamePath = $current_dir . '/' . $_REQUEST['newName'];
        rename($oldNamePath, $newNamePath); //ajoute $dir avant variables avec . !
    }


    if (isset($_POST['folder'])) {
        $folder = $_POST['folder'];
        $folder_path = $current_dir . "/" . $folder;
        if (!file_exists($folder_path)) {
            mkdir($folder_path);
        } else {
            echo "Folder already exists!";
        }
    }
    if (isset($_POST['file'])) {
        $file = $_POST['file'];
        if (!file_exists($current_dir . "/" . $file)) {
            touch($current_dir . "/" . $file);
        } else {
            echo "File already exists!";
        }
    }
    ?>

    <div class="flex-container">
        <?php
        $content = scandir($current_dir);
        foreach ($content as $file) {
            if ($file == '.' or $file == '..') {
                continue;
            }
            if (is_dir($current_dir . '/' . $file)) {
                ?>
                <div>
                    <li class='folder'>
                        <i class='fa fa-folder'></i><a
                                href='index.php?address=<?php echo $current_dir . '/' . $file; ?>'><p
                                    style="margin-left:10px;"><?php echo $file; ?></p></a>
                        <a href='index.php?delete=<?php echo $current_dir . '/' . $file; ?>&address=<?php echo $current_dir; ?>'><i
                                    class='fa fa-trash' style="color:darkblue;"></i></a>
                        <a href='index.php?edit=<?php echo $current_dir . '/' . $file; ?>&name=<?php echo $file; ?>&address=<?php echo $current_dir; ?>'><i
                                    class='fa fa-edit' style="color:darkblue;"></i></a>
                    </li>
                </div>
            <?php } else { ?>
                <div>
                    <li class='file'>
                        <i class='fa fa-file'></i><a href='view.php?name=<?php echo $current_dir . '/' . $file; ?>'><p
                                    style="margin-left:10px;"><?php echo $file ?></p></a>
                        <a href='index.php?delete=<?php echo $current_dir . '/' . $file ?>&address=<?php echo $current_dir; ?>'><i
                                    class='fa fa-trash' style='color:darkblue;'></i></a>
                        <a href='index.php?edit=<?php echo $current_dir . '/' . $file; ?>&name=<?php echo $file; ?>&address=<?php echo $current_dir; ?>'><i
                                    class='fa fa-edit' style='color:darkblue;'></i></a>
                    </li>
                </div>
            <?php }
        }
        ?>
    </div>
</ul>

<form action="" method="post">
    <div class="input-group">
        <input type="text" name="folder" placeholder="Directory name"/>
        <button type="submit" class="btn btn-outline-primary" value="creat">Creat</button>
    </div>

    <div class="input-group">
        <input type="text" name="file" placeholder="File name"/>
        <button type="submit" class="btn btn-outline-primary" value="creat">Creat</button>
    </div>

</form>

<form id="form-upload" action="./src/uploadFile.php" class="mt-4 w-50" style="display:flex;" method="POST" enctype="multipart/form-data">
    <input class="form-control form-control-lg" name="files" id="upload-input" type="file">

    <div class="input-group-append">
        <button type="submit" class="btn btn-outline-primary" style="height:95%;">Upload</button>
    </div>
</form>

<div class="row col-md-3 mx-2 mt-3 d-none" id="progressBarPlace">
    <span id="message" class="text-primary mx-4"></span>

    <div id="myProgress" class="progress p-0">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0"
             aria-valuemax="100">
            <span class="percent" style="width:100%;">0%</span>
        </div>
    </div>
</div>

<script>
    let form = document.getElementById('form-upload');

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        document.getElementById('progressBarPlace').classList.toggle('d-none')
        sendUploadedFile();
    });

    function sendUploadedFile() {
        let xhr = new XMLHttpRequest();
        xhr.open('POST', './src/uploadFile.php', true);
        let uploadedFile = document.getElementById('upload-input');
        //progressbar cod begin{
        let progrssBar = document.querySelector('#myProgress > .progress-bar');
        let percentText = progrssBar.querySelector('.percent');

        xhr.upload.addEventListener('progress', function (e) {
            console.log(e);
            if (e.total >= 300) {
                const darsad = e.lengthComputable ? (e.loaded / e.total) * 100 : 0;
                progrssBar.style.width = darsad.toFixed(2) + '%';
                percentText.textContent = darsad.toFixed(2) + '%';
            }
        });
        //progressbar code end}

        const formData = new FormData();
        formData.append('files', uploadedFile.files[0]);

        xhr.onreadystatechange = function () {
            let message = document.getElementById('message');
            console.log(this);
            if (this.status === 200) {
                message.innerHTML=this.response
                setInterval(function () {
                    location.reload();
                }, 5_000);
            } else if (this.status === 400) {
                message.textContent = this.responseText;
            }
        }
        xhr.send(formData);
    }
</script>

</body>

</html>