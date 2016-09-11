<div ng-controller="userPlaylistController">
    <!-- Modal -->
    <div class="modal fade" id="userPlaylistModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Playlists</h4>
                </div>
                <div class="modal-body">
                    <div ng-hide="editMode">
                        <h4>Create</h4>
                        <form name="createPlaylistForm" ng-submit="createPlaylist(createPlaylistForm.$valid)" novalidate>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Create Playlist..."
                                           ng-model="newPlaylistName" ng-disabled="creatingPlaylist" required>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="submit" ng-disabled="creatingPlaylist"><i class="fa fa-plus"></i></button>
                                    </span>
                                </div><!-- /input-group -->
                            </div>
                        </form>
                    </div>
                    <div ng-show="editMode">
                        <div class="alert text-center {{ editAlert }}" ng-show="showEditStatus">
                            <strong>{{ editMessage }}</strong>
                        </div>
                        <form name="editPlaylistForm" ng-submit="updatePlaylist(editPlaylistForm.$valid)" novalidate>
                            <div class="form-group">
                                <label>Playlist Name</label>
                                <input type="text" class="form-control" ng-model="editedPlaylist.playlist_name"
                                       required ng-minlength="1" ng-maxlength="255">
                            </div>
                            <div class="form-group">
                                <label>Type</label>
                                <select class="form-control" ng-model="editedPlaylist.playlist_type" required>
                                    <option value="1">Public</option>
                                    <option value="2">Private</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-save"></i> Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
