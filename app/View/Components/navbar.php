    <!--navbar-->
    <nav class="navbar navbar-expand-md bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="/">MaouNime</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/anime">Anime</a>
                    </li>
                </ul>
                <div class="ms-auto">
                    <?php if (isset($model['user'])) : ?>
                        <div class="dropdown-center">
                            <button class="btn btn-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= $model['user']['name'] ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-md-end">
                                <li><a class="dropdown-item" href="/users/profile">WatchList</a></li>
                                <li><a class="dropdown-item" href="/users/update">Update Profile</a></li>
                                <li><a class="dropdown-item" href="/users/password">Update Passowrd</a></li>
                                <li><a class="dropdown-item text-danger" href="/users/logout">Log Out</a></li>
                            </ul>
                        </div>
                    <?php  else: ?>
                        <a href="/users/login" class="btn btn-primary">Login</a>
                        <a href="/users/register" class="btn btn-primary">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <!-- end navbar-->