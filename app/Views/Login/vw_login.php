  <!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.79.0">
    <title>Sign-in</title>

    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>

    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/4.6/examples/sign-in/signin.css" rel="stylesheet">
</head>

<body class="text-center">
    <main class="form-signin">
        <?php if (!empty(session()->getFlashdata('error'))) : ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?php echo session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= base_url(); ?>/login/process">
            <?= csrf_field(); ?>
            <h1 class="h3 mb-3 fw-normal">Login</h1>
            <input type="text" name="username" id="username" placeholder="Username" class="form-control" required autofocus>
            <input type="password" name="password" id="password" placeholder="Password" class="form-control" required>

            <!-- Hidden input for tab token -->
            <input type="hidden" name="tab_token" id="tab_token" value="">

            <button type="submit" class="w-100 btn btn-lg btn-primary">Login</button>

            <!-- Register link -->
            <p class="mt-3 mb-3 text-muted">
                Don't have an account? <a href="<?= base_url(); ?>/register" class="link-primary">Register here</a>
            </p>

            <p class="mt-5 mb-3 text-muted">&copy; Sumber Jaya</p>
        </form>
    </main>

    <script>
        // Generate a unique token for each tab if not already set
        (function() {
            if (!sessionStorage.getItem('tab_token')) {
                sessionStorage.setItem('tab_token', Math.random().toString(36).substr(2, 9));
            }
            document.getElementById('tab_token').value = sessionStorage.getItem('tab_token');
        })();
    </script>
</body>
</html>
