<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/admin/reviews" class="brand-link">
        <span class="brand-text font-weight-light"><?= Yii::t('app', 'Admin panel') ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar users panel (optional) -->
        <!--        <div class="users-panel mt-3 pb-3 mb-3 d-flex">-->
        <!--            <div class="image">-->
        <!--                <img src="-->
        <? //= $assetDir ?><!--/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">-->
        <!--            </div>-->
        <!--            <div class="info">-->
        <!--                <a href="#" class="d-block">--><? //= Yii::$app->users->identity ?><!--</a>-->
        <!--            </div>-->
        <!--        </div>-->

        <!-- SidebarSearch Form -->
        <!-- href be escaped -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => Yii::$app->user->isGuest],

                    [
                        'label' => Yii::t('app', 'Users'),
                        'url' => ['/admin/users']
                    ],
                    [
                        'label' => Yii::t('app', 'Reviews'),
                        'items' => [
                            [
                                'label' => Yii::t('app', 'Reviews'),
                                'url' => ['/admin/reviews'],
                                'iconStyle' => 'far'
                            ],
                            [
                                'label' => Yii::t('app', 'Images'),
                                'url' => ['/admin/reviews-images'],
                                'iconStyle' => 'far'
                            ],
                        ]
                    ],
                    [
                        'label' => Yii::t('app', 'Comments'),
                        'items' => [
                            [
                                'label' => Yii::t('app', 'Comments'),
                                'url' => ['/admin/comments'],
                                'iconStyle' => 'far'
                            ],
                            [
                                'label' => Yii::t('app', 'Images'),
                                'url' => ['/admin/comments-images'],
                                'iconStyle' => 'far'
                            ],
                        ]
                    ],

                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>