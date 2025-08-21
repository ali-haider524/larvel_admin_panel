<!--Notification Modal -->
<div class="modal fade" id="usernotimodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Send Notification to Usern</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/push-notification/user" method="post">
                    @csrf
                    <input type="hidden" name="id" id="userid" />
                    
                     <div class="form-group">
                        <label for="recipient-name" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title">
                    </div>

                     <div class="form-group">
                        <label for="recipient-name" class="form-label">Message</label>
                        <input type="text" class="form-control" name="description">
                    </div>
              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-gradient-primary">Send Notification</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--END Notification Modal -->

<!--Ban Modal -->
<div class="modal fade" id="AcStatusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
           
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Account Ban</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="/users/ban" method="post">
                @csrf
            <div class="modal-body">
                 
                    <input type="hidden"  id="banid" name="id">
                    <input type="hidden" id="banstatus" name="status" >
                    
                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Reason</label>
                        <input type="text" class="form-control" name="reason" placeholder="suspicious activity">
                    </div>

               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-gradient-primary">Update Account Status</button>
            </div>
                
            </form>
        </div>
    </div>
</div>
<!--END Ban Modal -->



<!--Banner Modal -->
<div class="modal fade" id="bannerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Promotion Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/banner/create" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Banner Type:</label>
                        <select class="form-control" name="bannertype" id="choices-tag" placeholder="Select Banner Type">
                            <option value="" selected="">Select Banner Type</option>
                            <option value="slide">Slide Banner</option>
                            <option value="popup">Popup</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Banner on Click Action:</label>
                        <select class="form-control" name="onclick" id="choices-tag2" placeholder="Select Action">
                            <option value="" selected="">Select OnClick</option>
                            <option value="spin">Spin Screen</option>
                            <option value="scratch">Scratch Screen</option>
                            <option value="game">Game Screen</option>
                            <option value="video">VideoZone Screen</option>
                            <option value="web">Article Screen</option>
                            <option value="link">Link</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Url( Required only for Banner Action Link)</label>
                        <input type="text" class="form-control" name="link">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="orm-label">Select Banner</label>
                        <input type="file" class="form-control" name="icon" required>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-gradient-info">ADD</button>

                </form>
            </div>
        </div>
    </div>
</div>
<!--END Banner Modal -->

<!--UpdateBanner Modal -->
<div class="modal fade" id="bannerUpdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Promotion Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/banner/update" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="oldicon" name="oldicon">
                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Banner Type:</label>
                        <select class="form-control" name="bannertype" id="choices-tag" placeholder="Select Banner Type">
                            <option value="" selected="">Select Banner Type</option>
                            <option value="slide">Slide Banner</option>
                            <option value="popup">Popup</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Banner on Click Action:</label>
                        <select class="form-control" name="onclick" id="choices-tag2" placeholder="Select Action">
                            <option value="" selected="">Select OnClick</option>
                            <option value="spin">Spin Screen</option>
                            <option value="scratch">Scratch Screen</option>
                            <option value="game">Game Screen</option>
                            <option value="video">VideoZone Screen</option>
                            <option value="web">Article Screen</option>
                            <option value="link">Link</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Url( Required only for Banner Action Link)</label>
                        <input type="text" class="form-control" name="link" id="link">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="orm-label">Select Banner</label>
                        <input type="file" class="form-control" name="icon">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-gradient-info">Save Changes</button>

                </form>
            </div>
        </div>
    </div>
</div>
<!--END UpdateBanner Modal -->


<!--Game Modal -->
<div class="modal fade" id="gameModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Game</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/games/create" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Game Title</label>
                        <input type="text" class="form-control" name="title">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Game Link</label>
                        <input type="text" class="form-control" name="link">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="orm-label">Game Banner ( 200*200 )</label>
                        <input type="file" class="form-control" name="icon">
                    </div>

                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-gradient-info">ADD</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!--END Game Modal -->


<!--Game Update Modal -->
<div class="modal fade" id="gameupdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Game</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/games/update" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="gameid" name="id">
                    <input type="hidden" id="gameicon" name="oldicon">

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Game Title</label>
                        <input type="text" class="form-control" name="title" id="title">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Game Link</label>
                        <input type="text" class="form-control" name="link" id="gamelink">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="orm-label">Game Banner ( 200*200 )</label>
                        <input type="file" class="form-control" name="icon">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-gradient-info">Save Changes</button>

                </form>
            </div>
        </div>
    </div>
</div>
<!--END Game Modal -->



<!--Spin Modal -->
<div class="modal fade" id="spinmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Spin Row</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/luckywheel/create" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Spin Coin</label>
                        <input type="number" class="form-control" name="coin" required>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Color</label>
                        <input type="color" class="form-control" name="color">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-gradient-info">ADD</button>

                </form>
            </div>
        </div>
    </div>
</div>
<!--END Spin Modal -->


<!--Update Spin Modal -->
<div class="modal fade" id="spinupdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Spin Row</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/luckywheel/update" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="spinid" name="id">

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Spin Coin</label>
                        <input type="number" class="form-control" name="coin" id="coin" required>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Color</label>
                        <input type="color" class="form-control" name="color" id="color">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-gradient-info">Save Changes</button>

                </form>
            </div>
        </div>
    </div>
</div>
<!--END Update Spin Modal -->




<!--Reward Cat Modal -->
<div class="modal fade" id="rewardCatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Withdrawal Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/withdrawal/create" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="recipient-name" class="form-label"> Title</label>
                        <input type="text" class="form-control" name="name" id="name">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Available In Country (all=for all country)</label>
                        <input type="text" class="form-control" name="country" placeholder="US,IN" value="all">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="orm-label">Thumbnail(W 200* H 150 )</label>
                        <input type="file" class="form-control" name="icon" required>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-gradient-info">Add</button>

                </form>
            </div>
        </div>
    </div>
</div>

<!--Reward Cat Modal -->
<div class="modal fade" id="UpdaterewardCatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Withdrawal Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/withdrawal/update" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="catid" name="id">
                    <input type="hidden" id="oldicon" name="oldicon">
                    <div class="form-group">
                        <label for="recipient-name" class="form-label"> Title</label>
                        <input type="text" class="form-control" name="name" id="catname">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Available In Country (all=for all country)</label>
                        <input type="text" class="form-control" name="country" id="country" placeholder="US,IN" value="all">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="orm-label">Thumbnail(W 200* H 150 )</label>
                        <input type="file" class="form-control" name="icon">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-gradient-info">Save Changes</button>

                </form>
            </div>
        </div>
    </div>
</div>





<!--Faq Modal -->
<div class="modal fade" id="faqModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Faq</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/faq/create" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Faq Category:</label>
                        <select class="form-control" name="type" id="choices-tag2" placeholder="Select Category" required>
                            <option value="">Select</option>
                            <option value="faq">Faq</option>
                            <option value="account">Account Related</option>
                            <option value="invite">Invite Related</option>
                            <option value="dailyoffer">How Daily Offer Work</option>
                            <option value="cpi">How Custom Offer Work</option>
                            <option value="offerwall">How OfferWall Work</option>
                            <option value="spin">How Spin Work</option>
                            <option value="scratch">How Scratch Work</option>
                            <option value="game">How Game Task Work</option>
                            <option value="web">How Article Task Work</option>
                            <option value="video">How Videozone Task Work</option>
                            <option value="redeem">What is Withdrawal Process</option>
                            <option value="promote">How Promote Work</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Question</label>
                        <input type="text" class="form-control" name="question" placeholder="how is payment process" required>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Answer</label>
                        <textarea class="form-control" name="answer" required></textarea>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-gradient-info">Add</button>

                </form>
            </div>
        </div>
    </div>
</div>



<!--Update Faq Modal -->
<div class="modal fade" id="faqupdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Faq</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/faq/update" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="faqid">
                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Faq Category:</label>
                        <select class="form-control" name="type" id="type" placeholder="Select Category" required>
                            <option value="">Select</option>
                            <option value="faq">Faq</option>
                            <option value="account">Account Related</option>
                            <option value="invite">Invite Related</option>
                            <option value="dailyoffer">How Daily Offer Work</option>
                            <option value="cpi">How Custom Offer Work</option>
                            <option value="offerwall">How OfferWall Work</option>
                            <option value="spin">How Spin Work</option>
                            <option value="scratch">How Scratch Work</option>
                            <option value="game">How Game Task Work</option>
                            <option value="web">How Article Task Work</option>
                            <option value="video">How Videozone Task Work</option>
                            <option value="redeem">What is Withdrawal Process</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Question</label>
                        <input type="text" class="form-control" name="question" id="question" placeholder="how is payment process" required>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Answer</label>
                        <textarea class="form-control" name="answer" id="answer" required></textarea>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-gradient-info">Save Changes</button>

                </form>
            </div>
        </div>
    </div>
</div>


<!--Coinstore Modal -->
<div class="modal fade" id="storemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Package</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/coinstore/create" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Package Title</label>
                        <input type="text" class="form-control" name="title" placeholder="Gold Package" required>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Package Price in USD</label>
                        <input type="number" class="form-control" name="amount" placeholder="10" required>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Package Price in INR ( Required only if you select INR country)</label>
                        <input type="number" class="form-control" name="inr_amount" placeholder="100">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Coin ( User get coin after purchase)</label>
                        <input type="number" class="form-control" name="coin" placeholder="10000" required>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Package Available in Country ( Note : all= for worlwide) </label>
                        <input type="text" class="form-control" name="country" placeholder="IN,US" required>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-gradient-info">Add</button>

                </form>
            </div>
        </div>
    </div>
</div>


<!--Update Coinstore Modal -->
<div class="modal fade" id="updatestoremodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Package</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/coinstore/update" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="coinid" name="id">
                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Package Title</label>
                        <input type="text" class="form-control" name="title" id="coin_title" placeholder="Gold Package" required>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Package Price in USD</label>
                        <input type="number" class="form-control" name="amount" id="coin_amount" placeholder="10" required>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Package Price in INR ( Required only if you select INR country)</label>
                        <input type="number" class="form-control" name="inr_amount" id="coin_inr_amount" placeholder="100">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Coin ( User get coin after purchase)</label>
                        <input type="number" class="form-control" name="coin" id="coin_coin" placeholder="10000" required>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Package Available in Country ( Note : all= for worlwide) </label>
                        <input type="text" class="form-control" name="country" id="coin_country" placeholder="IN,US" required>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-gradient-info">Save Changes</button>

                </form>
            </div>
        </div>
    </div>
</div>




<!--balance Modal -->
<div class="modal fade" id="balanceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Coin Credit / Debit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/users/coins" method="POST" >
                    @csrf
                    <input type="hidden" name="id" id="uid">
                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Select Type:</label>
                        <select class="form-control" name="type" id="choices-tag2" placeholder="Select Type" required>
                            <option value="">Select</option>
                            <option value="credit">Credit</option>
                            <option value="debit">Debit</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Coin :</label>
                        <input type="number" class="form-control" name="coin" placeholder="How much coin you want to debit or credit" required>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Remark :</label>
                        <input type="text" class="form-control" name="remark" placeholder="Bonus Credited" required>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-gradient-info">Update Balance</button>

                </form>
            </div>
        </div>
    </div>
</div>



<!--promo update Modal -->
<div class="modal fade" id="promorejmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reject Promo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/promo_reject" method="POST" >
                    @csrf
                    <input type="hidden" name="id" id="promoid">
                    <input type="hidden" name="type" id="promotype">
   
                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Remark :</label>
                        <input type="text" class="form-control" name="remark" placeholder="Something is wrong or missing" required>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-gradient-info">Save Changes</button>

                </form>
            </div>
        </div>
    </div>
</div>


<!--dailyoffer update Modal -->
<div class="modal fade" id="dailyoffermodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reject Daily Offer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/dailyoffer/reject" method="POST" >
                    @csrf
                    <input type="hidden" name="id" id="dofferid">
   
                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Remark :</label>
                        <input type="text" class="form-control" name="remark" placeholder="Offer Not Complete wiht Rules" value="Offer Not Complete wiht Rules" required>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-gradient-danger">Reject</button>

                </form>
            </div>
        </div>
    </div>
</div>


<!--view survey  Modal -->
<div class="modal fade" id="previewSurveymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="doffertitle"> Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">×</span>
                </button>
            </div>
            <div class="modal-body">

                    <img src="" id="do_image" width="200" height="150"/>
                   
                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Offer Title :</label>
                        <label for="recipient-name" class="form-label" id="do_title"></label>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Offer Coin :</label>
                        <label for="recipient-name" class="form-label" id="do_coin"></label>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Offer Link :</label>
                        <label for="recipient-name" class="form-label" id="do_link"></label>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Offer Instruction :</label>
                        <label for="recipient-name" class="form-label" id="do_instruction"></label>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Payment Request Approve / Reject -->
<div class="modal fade" id="withdraw_approve" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Withdrawal Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/withdrawal/status/update" method="POST" >
                    @csrf
                    <input type="hidden" name="id" id="request_id">

                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Remark :</label>
                        <select name="type" class="form-control">
                            <option value="Success">Success</option>
                            <option value="Reject">Reject</option>
                        </select>
                    </div>
   
                    <div class="form-group">
                        <label for="recipient-name" class="form-label">Remark :</label>
                        <input type="text" class="form-control" name="remark" value="Your Payment will be sent" >
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn bg-gradient-danger">Update</button>

                </form>
            </div>
        </div>
    </div>
</div>


<!-- shoe postbackt -->
<div class="modal fade" id="postbackmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">PostBack Link</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="false">×</span>
                </button>
            </div>
            <div class="modal-body">
              
           <textarea class="form-control" id="pb" readonly></textarea>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
