<!DOCTYPE html>
<html>
<head>
	<title>Blind Zone</title>
    <script src="/js/jquery.min.js"></script>
    <script src="/js/jquery.dataTables.min.js"></script>
    <script src="/js/dataTables.bootstrap.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">

</head>
<body>
    <div class="container">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">Blind Zone</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <?php if(empty($_SESSION['userdata'])): ?>
                    <ul class="nav navbar-nav">
                        <li><a href="/">Home</a></li>
                        <li><a href="/about">About</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="/login">Login</a></li>
                        <li><a href="/register">Register</a></li>
                    </ul>
                    <?php else: ?>
                    <ul class="nav navbar-nav">
                        <li><a href="/">Home</a></li>
                        <li><a href="/about">About</a></li>
                        <li><a href="/projects">Projects</a></li>
                        <li><a href="/links">All interactions</a></li>
                        <?php if($_SESSION['userdata']['type'] == 'administrator'): ?>
                            <li><a href="/panel">Admin panel</a></li>
                        <?php endif; ?>
                        <li><a href="/payloads">Payloads</a></li>
                        <li><a href="/settings">Settings</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="/logout">Logout</a></li>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
