<div ng-controller="shareController">
    <!-- Modal -->
    <div class="modal fade" id="shareModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Share Track</h4>
                </div>
                <div class="modal-body">
                    <h4>Share on Social Media</h4>
                    <button type="button" class="btn btn-primary btn-block" ng-click="shareFB()"><i class="fa fa-facebook"></i> Share on Facebook</button>
                    <button type="button" class="btn btn-info btn-block" ng-click="shareTwitter()">
                        <i class="fa fa-twitter"></i> Tweet on Twitter
                    </button>
                    <hr>
                    <h4>Direct Link</h4>
                    <input type="text" readonly class="form-control" style="cursor: text;" ng-value="share_url">
                    <h4>Embed</h4>
                    <input type="text" readonly class="form-control" style="cursor: text;"
                           value='<iframe width="100%" height="42" frameborder="no" scrolling="no" src="{{ embed_url }}">'>
                </div>
            </div>
        </div>
    </div>
</div>
