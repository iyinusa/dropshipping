<div class="section">
    <div class="container">
        <div class="columns account-header">
            <div class="column is-10 is-offset-1 is-tablet-landscape-padded" style="min-height:90vh;">
                <div class="account-title">
                    <h2>Calculator</h2>
                    <img class="brand-filigrane" src="<?php echo base_url(); ?>assets/images/icon_inverse.png" alt="">
                </div>

                <div class="has-text-centered" style="padding: 15px; border-bottom: 1px solid #ddd; margin-bottom: 25px;">
                    <h2>Shipping Calculator</h2>
                    <div class="has-text-grey-light">Estimate your total ordering cost and delivery time using calculator below.</div>
                </div>
                
                <div class="columns">
                    <div class="column is-6">
                        <div class="columns">
                            <div class="column is-4">
                                <div class="control">
                                    <label class="label-text">Currency</label>
                                    <select id="currency" class="chosen-select form-control" style="width:100%;" onchange="calc();">
                                        <option value="yuan">¥ - Yuan</option>
                                        <option value="dollar">$ - Dollar</option>
                                    </select>
                                </div>
                            </div>
                            <div class="column is-8">
                                <div class="control">
                                    <label class="label-text">Product Cost</label>
                                    <input id="cost" type="text" class="input is-large" placeholder="25000" oninput="calc();">
                                </div>
                            </div>
                        </div>

                        <div class="columns">
                            <div class="column is-6">
                                <div class="control">
                                    <label class="label-text">Product Quantity</label>
                                    <input id="quantity" type="text" class="input is-large" placeholder="5" oninput="calc();">
                                </div>
                            </div>
                            <div class="column is-6">
                                <div class="control">
                                    <label class="label-text">Product Weight (Kg)</label>
                                    <input id="weight" type="number" class="input is-large" placeholder="2" oninput="calc();">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="column is-6 has-text-centered">
                        <div style="background-color: #ddd; font-size:large; padding: 15px 10px; margin: 20px 0px;">Estimated Cost</div>

                        <div style="font-size:36px; font-weight:bold;">
                            <small>&#8358;</small><span id="curr">0.00</span>
                        </div>
                        <span id="curr_info" class="has-text-grey-light"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>