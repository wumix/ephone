<aside class="nav-sidebar-ctr" ng-controller="sidebarCtrl">
    <uib-tabset justified="true">
        <uib-tab heading="Playlists">
            <ul class="nav nav-pills nav-stacked visible-sm visible-xs">
                <li><a ui-sref="discover"><i class="fa fa-globe"></i><span>Discover</span></a></li> <!-- Discover -->
                <li><a ui-sref="albums"><i class="fa fa-headphones"></i><span>Albums</span></a></li> <!-- Playlists -->
                <li><a ui-sref="events"><i class="fa fa-calendar"></i><span>Events</span></a></li> <!-- Playlists -->
                <li><a ui-sref="playlists"><i class="fa fa-music"></i><span>Playlists</span></a></li> <!-- Playlists -->
                <?php
                if(isset($_SESSION['loggedin'])){
                    ?>
                    <li><a ui-sref="manageTracks"><i class="fa fa-archive"></i> Manage Tracks</a></li>
                    <li><a href="profile/<?php echo $userRow['username']; ?>"><i class="fa fa-user"></i> My Profile</a></li>
                    <li><a ui-sref="editProfile"><i class="fa fa-pencil"></i> Edit Profile</a></li>
                    <li><a ui-sref="manageEvents"><i class="fa fa-calendar"></i> My Events</a></li>
                    <?php
                    if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == true){
                        ?><li ng-click="goToAdmin()"><a href="#"><i class="fa fa-dashboard"></i> Admin Dashboard</a></li><?php
                    }
                    ?>
                    <li><a ui-sref="pro" style="color: #DE578D;"><i class="fa fa-star"></i> Pro Membership</a></li>
                    <li><a ui-sref="logout"><i class="fa fa-power-off"></i> Logout</a></li>
                    <?php
                }else{
                    ?>
                    <li><a ui-sref="register" ng-show="settings.user_registration == 1"><i class="fa fa-plus"></i> Register</a></li>
                    <li><a ui-sref="login"><i class="fa fa-sign-in"></i> Login</a></li>
                    <?php
                }
                ?>
            </ul>

            <h3>My Playlists</h3>

            <div ng-if="!logged_in" class="text-center"><a ui-sref="login" class="text-muted">Please login to view your playlists.</a></div>

            <ul class="nav nav-pills nav-stacked" ng-if="logged_in">
                <li><a href="#" data-toggle="modal" data-target="#userPlaylistModal" ng-click="switchToCreateMode()"><i class="fa fa-plus-circle"></i> Create a Playlist</a></li>
                <li ng-repeat="p in personal_playlists">
                    <a href="playlist/{{ p.id }}">
                        <i class="fa fa-book"></i> {{ p.playlist_name }}
                        <button type="button" class="pull-right" ng-click="deletePlaylist($event, p, $index)"><i class="fa fa-remove"></i></button>
                        <button type="button" data-toggle="modal" data-target="#userPlaylistModal" ng-click="editPlaylist($event, p)" class="pull-right"><i class="fa fa-pencil"></i></button>
                    </a>
                </li>
            </ul>

            <div class="userPlaylistCtr" ng-repeat="playlist in userPlaylists">
                <strong>{{ playlist.playlist_name }}</strong>
                <button type="button" class="btn btn-sm btn-danger pull-right"
                        ng-click="deletePlaylist(playlist, $index)"><i class="fa fa-ban"></i></button>
                <button type="button" class="btn btn-sm btn-info pull-right"
                        ng-click="editPlaylist(playlist)"><i class="fa fa-cog"></i></button>
            </div>

            <ul class="nav nav-pages">
                <?php
                foreach($pages as $page){
                    ?><li><a href="p/<?php echo $page['page_slug']; ?>"><?php echo $page['title']; ?></a></li><?php
                }
                ?>
            </ul>
        </uib-tab>
        <uib-tab heading="Queue">
            <div ng-repeat="playlist_track in playlistTracks" class="playlist-single-track-ctr">
                <div class="track-img"><img ng-src="uploads/{{ playlist_track.track_img }}"></div>
                <div class="track-title">{{ playlist_track.title }}</div>
            </div>
        </uib-tab>
    </uib-tabset>
</aside>