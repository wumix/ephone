<nav class="navbar navbar-white navbar-fixed-top" ng-controller="navController">
    <div class="colorful-header"><div></div><div></div><div></div><div></div></div>
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" id="sidebarToggleBtn"><i class="fa fa-bars"></i></button>
            <a class="navbar-brand" ui-sref="home"><i class="flaticon-person188"></i> <?php echo $settings['site_name']; ?></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="euphonize-main-navbar">
            <ul class="nav navbar-nav navbar-icons">
                <li><a ui-sref="discover"><i class="flaticon-disc15"></i><span>Discover</span></a></li> <!-- Discover -->
                <li><a ui-sref="albums"><i class="fa fa-headphones"></i><span>Albums</span></a></li> <!-- Playlists -->
                <li><a ui-sref="events"><i class="fa fa-calendar"></i><span>Events</span></a></li> <!-- Playlists -->
                <li><a ui-sref="playlists"><i class="fa fa-music"></i><span>Playlists</span></a></li> <!-- Playlists -->
                <!-- <li><a ui-sref="artists"><i class="fa fa-microphone"></i><span>Artists</span></a></li> Artists -->
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
                if(isset($_SESSION['loggedin'])){
                ?>
                <li><a ui-sref="manageTracks" class="btn btn-blue navbar-btn"><i class="flaticon-music234"></i> Manage Tracks</a></li>
                <li class="notification-dropdown">
                    <a ui-sref="inbox"><i class="flaticon-smartphone55"></i></a>
                    <i class="fa fa-exclamation-circle" ng-show="hasMessages"></i>
                </li>
                <li class="notification-dropdown dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                       ng-click="hasAlerts = false"><i class="flaticon-notify"></i></a>
                    <i class="fa fa-exclamation-circle" ng-show="hasAlerts"></i>
                    <ul class="dropdown-menu" role="menu">
                        <li ng-hide="alerts.length">
                            <p class="text-center">No Notifications</p>
                        </li>
                        <li ng-repeat="alert in alerts">
                            <div class="notification-img">
                                <a href="profile/{{ alert.username }}">
                                    <img ng-src="uploads/{{ alert.profile_img }}" class="img-responsive">
                                </a>
                            </div>
                            <div class="notification-details" ng-show="alert.a_type == 1">
                                <a href="profile/{{ alert.username }}">{{ alert.display_name }}</a> is now following you.
                                <span>{{ alert.time_created }}</span>
                            </div>
                            <div class="notification-details" ng-show="alert.a_type == 2">
                                <a href="profile/{{ alert.username }}">{{ alert.display_name }}</a> liked your track
                                <a href="track/{{ alert.track_url }}-{{ alert.tid}}">{{ alert.track_title }}</a>.<br>
                                <span>{{ alert.time_created }}</span>
                            </div>
                            <div class="notification-details" ng-show="alert.a_type == 3">
                                <a href="profile/{{ alert.username }}">{{ alert.display_name }}</a> commented on your track
                                <a href="track/{{ alert.track_url }}-{{ alert.tid}}">{{ alert.track_title }}</a>.<br>
                                <span>{{ alert.time_created }}</span>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="dropdown navbar-profile">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="uploads/<?php echo $userRow['profile_img']; ?>" id="menu-profile-img">
                        <?php echo $userRow['username']; ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="profile/<?php echo $userRow['username']; ?>"><i class="fa fa-user"></i> My Profile</a></li>
                        <li><a ui-sref="editProfile"><i class="fa fa-pencil"></i> Edit Profile</a></li>
                        <li><a ui-sref="manageEvents"><i class="fa fa-calendar"></i> My Events</a></li>
                        <?php
                        if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == true){
                        ?>
                            <li ng-click="goToAdmin()">
                                <a href="#">
                                    <i class="fa fa-dashboard"></i> Admin Dashboard
                                </a>
                            </li>
                        <?php
                        }
                        ?>
                        <li><a ui-sref="pro" style="color: #DE578D;"><i class="fa fa-star"></i> Pro Membership</a></li>
                        <li><a ui-sref="logout"><i class="fa fa-power-off"></i> Logout</a></li>
                    </ul>
                </li>
                <?php
                }else{
                ?>
                <li><a ui-sref="register" class="btn btn-default navbar-btn" ng-show="settings.user_registration == 1"><i class="fa fa-plus"></i> Register</a></li>
                <li><a ui-sref="login" class="btn btn-default navbar-btn"><i class="fa fa-sign-in"></i> Login</a></li>
                <?php } ?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>