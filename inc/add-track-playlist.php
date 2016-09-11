<div ng-controller="addTrackPlaylistController">
    <!-- Modal -->
    <div class="modal fade" id="addPlaylistTrackModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">My Playlists</h4>
                </div>
                <div class="modal-body">
                    <div ng-show="loggedIn">
                        <p>Please login/register to add this to your playlist.</p>
                    </div>
                    <div ng-show="checkingTrack" class="text-center">
                        <i class="fa fa-refresh fa-spin fa-5x"></i>
                    </div>
                    <div ng-hide="checkingTrack && loggedIn">
                        <div class="playlistItem" ng-repeat="playlist in addTrackPlaylists"
                             ng-click="toggleTrackPlaylist(playlist, $event)">
                            <strong>{{ playlist.playlist_name }}</strong>
                            <i class="fa pull-right"
                                ng-class="{ 'fa-plus': playlist.hasTrack == 0, 'fa-check': playlist.hasTrack != 0 }"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
