<div id="RiskProfileModalPoup_1" class="uk-flex-top uk-modal-container" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical" style="border-radius: 18px;">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <h2 class="uk-modal-title">My risk profile</h2>
        <div class="uk-child-width-expand@s uk-grid-divider" uk-grid>
            <div>
                <h4>Based on your selections, your attitude to risk is:</h4>
                <table class="uk-table uk-table-small atr-table atr-table-minimised" width="100%">
                    <tbody>
                        <?php if(IsMobileBrowser() === true) :?>
                        <tr>
                            <td>
                                <h4 class="uk-text-center">Defensive</h4>
                                <div class="atr-risk-value">1</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Cautious</p>
                                <div>2</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Balanced</p>
                                <div>3</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="uk-text-center">
                                <p>Moderate</p>
                                <div>4</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Adventurous</p>
                                <div>5</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Aggressive</p>
                                <div>6</div>
                            </td>
                        </tr>
                        <?php else :?>
                        <tr>
                            <td>
                                <h4 class="uk-text-center">Defensive</h4>
                                <div class="atr-risk-value">1</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Cautious</p>
                                <div>2</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Balanced</p>
                                <div>3</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Moderate</p>
                                <div>4</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Adventurous</p>
                                <div>5</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Aggressive</p>
                                <div>6</div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <h4>What does ‘Defensive’ mean?</h4>
                <p>You are not prepared to take any investment risk, as far as possible. You are likely to need a large
                    portion or all your money soon.</p>
                <table class="uk-table uk-table-small" width="100%">
                    <tbody>
                        <tr>
                            <td width="30px"><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg"
                                    style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#039bcb" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Cash</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">Cash and cash
                                equivalents, including money market funds</td>
                        </tr>
                        <tr>
                            <td width="30px"><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg"
                                    style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#4173b3" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Fixed&nbsp;income</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">Government &
                                corporate bonds, certificates of deposit</td>
                        </tr>
                        <tr>
                            <td><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg" style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#8249ae" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Equity</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">Stocks or shares in
                                companies</td>
                        </tr>
                        <tr>
                            <td><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg" style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#973b8f" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Aggressive growth assets</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">Concentrated equity
                                exposure and private equity</td>
                        </tr>
                        <tr>
                            <td><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg" style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#c21f7d" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Specialist assets</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">High-risk
                                alternative
                                assets and use of leverage</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="uk-width-2-5@s">
                <h4>Suggested asset mix</h4>
                <div class="uk-text-center">
                    <img src="<?php echo assets_url('concerto/icons/risk-score-1.svg');?>" style="width: 260px;" />
                    <table class="uk-table uk-table-small uk-table-divider" width="100%">
                        <tbody>
                            <tr>
                                <td width="30px"><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg"
                                        style="margin-top: -4px">
                                        <circle r="8" cx="10" cy="10" fill="#039bcb" />
                                    </svg></td>
                                <td class="uk-text-left uk-padding-remove-left">Cash</td>
                                <td>100%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="uk-text-center">
            <div class="uk-text-center uk-margin-medium-top">
                <button
                    class="uk-button uk-button-default uk-text-capitalize uk-width-1-4 uk-modal-close uk-border-pill">Close</button>
            </div>
        </div>
    </div>
</div>


<div id="RiskProfileModalPoup_2" class="uk-flex-top uk-modal-container" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical" style="border-radius: 18px;">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <h2 class="uk-modal-title">My risk profile</h2>
        <div class="uk-child-width-expand@s uk-grid-divider" uk-grid>
            <div>
                <h4>Based on your selections, your attitude to risk is:</h4>
                <table class="uk-table uk-table-small atr-table atr-table-minimised" width="100%">
                    <tbody>
                        <?php if(IsMobileBrowser() === true) :?>
                        <tr>

                            <td class="uk-text-center">
                                <p>Defensive</p>
                                <div>1</div>
                            </td>
                            <td class="uk-text-center">
                                <h4 class="uk-text-center">Cautious</h4>
                                <div class="atr-risk-value">2</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Balanced</p>
                                <div>3</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="uk-text-center">
                                <p>Moderate</p>
                                <div>4</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Adventurous</p>
                                <div>5</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Aggressive</p>
                                <div>6</div>
                            </td>
                        </tr>
                        <?php else :?>
                        <tr>
                            <td class="uk-text-center">
                                <p>Defensive</p>
                                <div>1</div>
                            </td>
                            <td class="uk-text-center">
                                <h4 class="uk-text-center">Cautious</h4>
                                <div class="atr-risk-value">2</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Balanced</p>
                                <div>3</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Moderate</p>
                                <div>4</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Adventurous</p>
                                <div>5</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Aggressive</p>
                                <div>6</div>
                            </td>
                        </tr>
                        <?php endif; ?>

                    </tbody>
                </table>
                <h4>What does ‘Cautious’ mean?</h4>
                <p>You are prepared to take only a small amount of investment risk. You wish to prioritise
                    preservation of capital over high returns.</p>
                <table class="uk-table uk-table-small" width="100%">
                    <tbody>
                        <tr>
                            <td width="30px"><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg"
                                    style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#039bcb" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Cash</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">Cash and cash
                                equivalents, including money market funds</td>
                        </tr>
                        <tr>
                            <td width="30px"><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg"
                                    style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#4173b3" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Fixed&nbsp;income</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">Government &
                                corporate bonds, certificates of deposit</td>
                        </tr>
                        <tr>
                            <td><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg" style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#8249ae" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Equity</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">Stocks or shares in
                                companies</td>
                        </tr>
                        <tr>
                            <td><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg" style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#973b8f" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Aggressive growth assets</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">Concentrated equity
                                exposure and private equity</td>
                        </tr>
                        <tr>
                            <td><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg" style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#c21f7d" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Specialist assets</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">High-risk
                                alternative assets and use of leverage</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="uk-width-2-5@s">
                <h4>Suggested asset mix</h4>
                <div class="uk-text-center">
                    <img src="<?php echo assets_url('concerto/icons/risk-score-2.svg');?>" style="width: 260px;" />
                    <table class="uk-table uk-table-small uk-table-divider" width="100%">
                        <tbody>
                            <tr>
                                <td width="30px"><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg"
                                        style="margin-top: -4px">
                                        <circle r="8" cx="10" cy="10" fill="#039bcb" />
                                    </svg></td>
                                <td class="uk-text-left uk-padding-remove-left">Cash</td>
                                <td>50%</td>
                            </tr>
                            <tr>
                                <td><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg"
                                        style="margin-top: -4px">
                                        <circle r="8" cx="10" cy="10" fill="#4173b3" />
                                    </svg></td>
                                <td class="uk-text-left uk-padding-remove-left">Fixed income</td>
                                <td>50%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="uk-text-center">
            <div class="uk-text-center uk-margin-medium-top">
                <button
                    class="uk-button uk-button-default uk-text-capitalize uk-width-1-4 uk-modal-close uk-border-pill">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="RiskProfileModalPoup_3" class="uk-flex-top uk-modal-container" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical" style="border-radius: 18px;">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <h2 class="uk-modal-title">My risk profile</h2>
        <div class="uk-child-width-expand@s uk-grid-divider" uk-grid>
            <div>
                <h4>Based on your selections, your attitude to risk is:</h4>
                <table class="uk-table uk-table-small atr-table atr-table-minimised" width="100%">
                    <tbody>
                        <?php if(IsMobileBrowser() === true) :?>
                        <tr>

                            <td class="uk-text-center">
                                <p>Defensive</p>
                                <div>1</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Cautious</p>
                                <div>2</div>
                            </td>
                            <td>
                                <h4 class="uk-text-center">Balanced</h4>
                                <div class="atr-risk-value">3</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="uk-text-center">
                                <p>Moderate</p>
                                <div>4</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Adventurous</p>
                                <div>5</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Aggressive</p>
                                <div>6</div>
                            </td>
                        </tr>
                        <?php else :?>
                        <tr>
                            <td>
                                <p>Defensive</p>
                                <div>1</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Cautious</p>
                                <div>2</div>
                            </td>
                            <td>
                                <h4 class="uk-text-center">Balanced</h4>
                                <div class="atr-risk-value">3</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Moderate</p>
                                <div>4</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Adventurous</p>
                                <div>5</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Aggressive</p>
                                <div>6</div>
                            </td>
                        </tr>
                        <?php endif; ?>

                    </tbody>
                </table>
                <h4>What does ‘Balanced’ mean?</h4>
                <p>You are prepared to take a limited investment risk to increase chance of achieving a positive
                    return. You only wish to risk a small part of capital to achieve positive returns.</p>
                <table class="uk-table uk-table-small" width="100%">
                    <tbody>
                        <tr>
                            <td width="30px"><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg"
                                    style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#039bcb" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Cash</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">Cash and cash
                                equivalents, including money market funds</td>
                        </tr>
                        <tr>
                            <td width="30px"><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg"
                                    style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#4173b3" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Fixed&nbsp;income</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">Government &
                                corporate bonds, certificates of deposit</td>
                        </tr>
                        <tr>
                            <td><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg" style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#8249ae" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Equity</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">Stocks or shares in
                                companies</td>
                        </tr>
                        <tr>
                            <td><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg" style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#973b8f" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Aggressive growth assets</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">Concentrated equity
                                exposure and private equity</td>
                        </tr>
                        <tr>
                            <td><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg" style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#c21f7d" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Specialist assets</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">High-risk
                                alternative
                                assets and use of leverage</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="uk-width-2-5@s">
                <h4>Suggested asset mix</h4>
                <div class="uk-text-center">
                    <img src="<?php echo assets_url('concerto/icons/risk-score-3.svg');?>" style="width: 260px;" />
                    <table class="uk-table uk-table-small uk-table-divider" width="100%">
                        <tbody>
                            <tr>
                                <td width="30px"><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg"
                                        style="margin-top: -4px">
                                        <circle r="8" cx="10" cy="10" fill="#4173b3" />
                                    </svg></td>
                                <td class="uk-text-left uk-padding-remove-left">Fixed income</td>
                                <td>55%</td>
                            </tr>
                            <tr>
                                <td><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg"
                                        style="margin-top: -4px">
                                        <circle r="8" cx="10" cy="10" fill="#8249ae" />
                                    </svg></td>
                                <td class="uk-text-left uk-padding-remove-left">Equity</td>
                                <td>45%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="uk-text-center">
            <div class="uk-text-center uk-margin-medium-top">
                <button
                    class="uk-button uk-button-default uk-text-capitalize uk-width-1-4 uk-modal-close uk-border-pill">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="RiskProfileModalPoup_4" class="uk-flex-top uk-modal-container" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical" style="border-radius: 18px;">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <h2 class="uk-modal-title">My risk profile</h2>
        <div class="uk-child-width-expand@s uk-grid-divider" uk-grid>
            <div>
                <h4>Based on your selections, your attitude to risk is:</h4>
                <table class="uk-table uk-table-small atr-table atr-table-minimised" width="100%">
                    <tbody>
                        <?php if(IsMobileBrowser() === true) :?>
                        <tr>
                            <td class="uk-text-center">
                                <p>Defensive</p>
                                <div>1</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Cautious</p>
                                <div>2</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Balanced</p>
                                <div>3</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h4 class="uk-text-center">Moderate</h4>
                                <div class="atr-risk-value">4</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Adventurous</p>
                                <div>5</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Aggressive</p>
                                <div>6</div>
                            </td>
                        </tr>
                        <?php else :?>
                        <tr>
                            <td class="uk-text-center">
                                <p>Defensive</p>
                                <div>1</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Cautious</p>
                                <div>2</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Balanced</p>
                                <div>3</div>
                            </td>
                            <td>
                                <h4 class="uk-text-center">Moderate</h4>
                                <div class="atr-risk-value">4</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Adventurous</p>
                                <div>5</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Aggressive</p>
                                <div>6</div>
                            </td>
                        </tr>
                        <?php endif; ?>

                    </tbody>
                </table>
                <h4>What does ‘Moderate’ mean?</h4>
                <p>You are prepared to take a moderate amount of investment risk in to increase the chance of
                    achieving a positive return. Providing capital protection is less important to you than achieving a
                    better return on your investment.</p>
                <table class="uk-table uk-table-small" width="100%">
                    <tbody>
                        <tr>
                            <td width="30px"><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg"
                                    style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#039BCB" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Cash</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">Cash and cash
                                equivalents</td>
                        </tr>
                        <tr>
                            <td width="30px"><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg"
                                    style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#4173B3" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Fixed&nbsp;income</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">Bonds, certificate
                                of deposit, money market funds</td>
                        </tr>
                        <tr>
                            <td><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg" style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#8249AE" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Equity</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">Stocks or shares in
                                companies</td>
                        </tr>
                        <tr>
                            <td><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg" style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#973B8F" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Aggressive growth assets</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">Concentrated equity exposure and private equity</td>
                        </tr>
						<tr>
                            <td><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg" style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#C21F7D" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Specialist assets</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">High-risk alternative assets and use of leverage</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="uk-width-2-5@s">
                <h4>Suggested asset mix</h4>
                <div class="uk-text-center">
                    <img src="<?php echo assets_url('concerto/icons/risk-score-4.svg');?>" style="width: 260px;" />
                    <table class="uk-table uk-table-small uk-table-divider" width="100%">
                        <tbody>
                            <tr>
                                <td width="30px"><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg"
                                        style="margin-top: -4px">
                                        <circle r="8" cx="10" cy="10" fill="#4173B3" />
                                    </svg></td>
                                <td class="uk-text-left uk-padding-remove-left">Fixed income</td>
                                <td>5%</td>
                            </tr>
                            <tr>
                                <td><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg"
                                        style="margin-top: -4px">
                                        <circle r="8" cx="10" cy="10" fill="#8249AE" />
                                    </svg></td>
                                <td class="uk-text-left uk-padding-remove-left">Equity</td>
                                <td>90%</td>
                            </tr>
                            <tr>
                                <td><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg"
                                        style="margin-top: -4px">
                                        <circle r="8" cx="10" cy="10" fill="#973B8F" />
                                    </svg></td>
                                <td class="uk-text-left uk-padding-remove-left">Aggressive growth assets</td>
                                <td>5%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="uk-text-center">
            <div class="uk-text-center uk-margin-medium-top">
                <button
                    class="uk-button uk-button-default uk-text-capitalize uk-width-1-4 uk-modal-close uk-border-pill">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="RiskProfileModalPoup_5" class="uk-flex-top uk-modal-container" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical" style="border-radius: 18px;">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <h2 class="uk-modal-title">My risk profile</h2>
        <div class="uk-child-width-expand@s uk-grid-divider" uk-grid>
            <div>
                <h4>Based on your selections, your attitude to risk is:</h4>
                <table class="uk-table uk-table-small atr-table atr-table-minimised" width="100%">
                    <tbody>
                        <?php if(IsMobileBrowser() === true) :?>
                        <tr>

                            <td class="uk-text-center">
                                <p>Defensive</p>
                                <div>1</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Cautious</p>
                                <div>2</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Balanced</p>
                                <div>3</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="uk-text-center">
                                <p>Moderate</p>
                                <div>4</div>
                            </td>
                            <td class="uk-text-center">
                                <h4 class="uk-text-center">Adventurous</h4>
                                <div class="atr-risk-value">5</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Aggressive</p>
                                <div>6</div>
                            </td>
                        </tr>
                        <?php else :?>
                        <tr>
                            <td class="uk-text-center">
                                <p>Defensive</p>
                                <div>1</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Cautious</p>
                                <div>2</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Balanced</p>
                                <div>3</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Moderate</p>
                                <div>4</div>
                            </td>
                            <td class="uk-text-center">
                                <h4 class="uk-text-center">Adventurous</h4>
                                <div class="atr-risk-value">5</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Aggressive</p>
                                <div>6</div>
                            </td>
                        </tr>
                        <?php endif; ?>

                    </tbody>
                </table>
                <h4>What does ‘Adventurous’ mean?</h4>
                <p>You are prepared to take a medium degree of risk in return for the possibility of improving longer
                    term investment performance. Providing short term capital protection is not important to you,
                    and you are willing to sacrifice some long-term protection for the likelihood of greater returns.
                </p>
                <table class="uk-table uk-table-small" width="100%">
                    <tbody>
                        <tr>
                            <td width="30px"><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg"
                                    style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#039bcb" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Cash</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">Cash and cash
                                equivalents, including money market funds</td>
                        </tr>
                        <tr>
                            <td width="30px"><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg"
                                    style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#4173b3" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Fixed&nbsp;income</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">Government &
                                corporate bonds, certificates of deposit</td>
                        </tr>
                        <tr>
                            <td><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg" style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#8249ae" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Equity</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">Stocks or shares in
                                companies</td>
                        </tr>
                        <tr>
                            <td><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg" style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#973b8f" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Aggressive growth assets</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">Concentrated equity
                                exposure and private equity</td>
                        </tr>
                        <tr>
                            <td><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg" style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#c21f7d" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Specialist assets</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">High-risk
                                alternative
                                assets and use of leverage</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="uk-width-2-5@s">
                <h4>Suggested asset mix</h4>
                <div class="uk-text-center">
                    <img src="<?php echo assets_url('concerto/icons/risk-score-5.svg');?>" style="width: 260px;" />
                    <table class="uk-table uk-table-small uk-table-divider" width="100%">
                        <tbody>
                            <tr>
                                <td><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg"
                                        style="margin-top: -4px">
                                        <circle r="8" cx="10" cy="10" fill="#973b8f" />
                                    </svg></td>
                                <td class="uk-text-left uk-padding-remove-left">Aggressive growth assets</td>
                                <td>100%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="uk-text-center">
            <div class="uk-text-center uk-margin-medium-top">
                <button
                    class="uk-button uk-button-default uk-text-capitalize uk-width-1-4 uk-modal-close uk-border-pill">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="RiskProfileModalPoup_6" class="uk-flex-top uk-modal-container" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical" style="border-radius: 18px;">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <h2 class="uk-modal-title">My risk profile</h2>
        <div class="uk-child-width-expand@s uk-grid-divider" uk-grid>
            <div>
                <h4>Based on your selections, your attitude to risk is:</h4>
                <table class="uk-table uk-table-small atr-table atr-table-minimised" width="100%">
                    <tbody>
                        <?php if(IsMobileBrowser() === true) :?>
                        <tr>

                            <td class="uk-text-center">
                                <p>Defensive</p>
                                <div>1</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Cautious</p>
                                <div>2</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Balanced</p>
                                <div>3</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="uk-text-center">
                                <p>Moderate</p>
                                <div>4</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Adventurous</p>
                                <div>5</div>
                            </td>
                            <td>
                                <h4 class="uk-text-center">Aggressive</h4>
                                <div class="atr-risk-value">6</div>
                            </td>
                        </tr>
                        <?php else :?>
                        <tr>
                            <td class="uk-text-center">
                                <p>Defensive</p>
                                <div>1</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Cautious</p>
                                <div>2</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Balanced</p>
                                <div>3</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Moderate</p>
                                <div>4</div>
                            </td>
                            <td class="uk-text-center">
                                <p>Adventurous</p>
                                <div>5</div>
                            </td>
                            <td>
                                <h4 class="uk-text-center">Aggressive</h4>
                                <div class="atr-risk-value">6</div>
                            </td>
                        </tr>
                        <?php endif; ?>

                    </tbody>
                </table>
                <h4>What does ‘Aggressive’ mean?</h4>
                <p>You are prepared to take a substantial degree of risk with your investment in return for the
                    prospect of the highest possible longer term investment performance. You appreciate that over
                    some periods of time there can be significant falls, as well as rises, in the value of your
                    investment and you may get back less than you invest.</p>
                <table class="uk-table uk-table-small" width="100%">
                    <tbody>
                        <tr>
                            <td width="30px"><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg"
                                    style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#039bcb" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Cash</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">Cash and cash
                                equivalents, including money market funds</td>
                        </tr>
                        <tr>
                            <td width="30px"><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg"
                                    style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#4173b3" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Fixed&nbsp;income</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">Government &
                                corporate bonds, certificates of deposit</td>
                        </tr>
                        <tr>
                            <td><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg" style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#8249ae" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Equity</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">Stocks or shares in
                                companies</td>
                        </tr>
                        <tr>
                            <td><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg" style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#973b8f" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Aggressive growth assets</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">Concentrated equity
                                exposure and private equity</td>
                        </tr>
                        <tr>
                            <td><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg" style="margin-top: -4px">
                                    <circle r="8" cx="10" cy="10" fill="#c21f7d" />
                                </svg></td>
                            <td class="uk-text-left uk-padding-remove-left">Specialist assets</td>
                            <td class="uk-text-left uk-padding-remove-left" style="font-size: 12px">High-risk
                                alternative
                                assets and use of leverage</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="uk-width-2-5@s">
                <h4>Suggested asset mix</h4>
                <div class="uk-text-center">
                    <img src="<?php echo assets_url('concerto/icons/risk-score-6.svg');?>" style="width: 260px;" />
                    <table class="uk-table uk-table-small uk-table-divider" width="100%">
                        <tbody>
                            <tr>
                                <td><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg"
                                        style="margin-top: -4px">
                                        <circle r="8" cx="10" cy="10" fill="#973b8f" />
                                    </svg></td>
                                <td class="uk-text-left uk-padding-remove-left">Aggressive growth assets</td>
                                <td>40%</td>
                            </tr>
                            <tr>
                                <td><svg height="20" width="20" xmlns="http://www.w3.org/2000/svg"
                                        style="margin-top: -4px">
                                        <circle r="8" cx="10" cy="10" fill="#c21f7d" />
                                    </svg></td>
                                <td class="uk-text-left uk-padding-remove-left">Specialist assets</td>
                                <td>60%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="uk-text-center">
            <div class="uk-text-center uk-margin-medium-top">
                <button
                    class="uk-button uk-button-default uk-text-capitalize uk-width-1-4 uk-modal-close uk-border-pill">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
.uk-accordion-title::before {
    background-color: white;
    border: 1px solid white;
    border-radius: 50%;
}

table.atr-table-minimised td {
    padding: 8px !important;
}

.atr-table-minimised p,
.atr-table-minimised ul,
.atr-table-minimised li {
    margin-top: 3px;
    margin-bottom: 3px;
    font-size: 12px;
}

.atr-table-minimised h4 {
    margin-bottom: 3px;
}

table.atr-table-minimised tr:nth-child(7) td,
table.atr-table-minimised tr:nth-child(8) td {
    vertical-align: top;
}

table.atr-table-minimised tr:nth-child(7) td {
    border-top: 1px solid #d4d4d4;
}

table.atr-table-minimised tr:nth-child(7) td:first-child,
table.atr-table-minimised tr:nth-child(3) td:first-child {
    border-top: 1px solid white;
    border-right: 1px solid white;
    border-bottom: 1px solid white;
}

table.atr-table-minimised tr:first-child td {
    border-bottom: 1px solid white;
    border-right: 1px solid white;
}

table.atr-table-minimised tr:nth-child(2) td {
    border-bottom: 1px solid white;
    border-right: 1px solid white;
}

.more-risk-down {
    background-image: url("../assets/concerto/pix/more-risk-down.svg");
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
}

.more-risk-right {
    background-image: url("../assets/concerto/pix/more-risk-right.svg");
    background-size: contain;
    background-repeat: no-repeat;
    height: 20px;
    background-position: center;
}
</style>


<div id="modal-icons" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical" style="border-radius: 18px;">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <h2 class="uk-modal-title">Indicators</h2>
        <div uk-grid>
            <div><img src="<?php echo assets_url('concerto/icons/icon-check.svg');?>" width="35px" height="35px"
                    class="uk-align-left uk-margin-small-right" /></div>
            <div class="uk-width-expand uk-padding-remove-left">
                <p>Your survey responses indicate you are in this risk zone for this section of the survey.</p>
            </div>
        </div>
        <div uk-grid>
            <div><img src="<?php echo assets_url('concerto/icons/icon-warning.svg');?>" width="35px" height="35px"
                    class="uk-align-left uk-margin-small-right" /></div>
            <div class="uk-width-expand uk-padding-remove-left">
                <p>Your answers in this section do not match your overall
                    risk profile. You may need to adjust your expectations to give yourself the best chance of achieving
                    your
                    investment goals. We recommend reviewing your results with a financial advisor.</p>
            </div>
        </div>

        <div class="uk-text-center uk-margin-top">
            <button class="uk-button uk-button-default uk-border-pill uk-modal-close uk-text-capitalize"
                type="button">Close</button>
        </div>
    </div>
</div>
<div id="risk-explained" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Risk - explained</h2>
        </div>
        <div class="uk-modal-body" uk-overflow-auto>
            <p>Your personal risk profile is based on your age, plan value and survey responses. There is no 'good' or
                'bad' profile. The best approach is to match your risk profile to your investments. You can check how
                different your financial position might look with other risk profiles on the ‘<a
                    href="<?php echo website_url($this->controller.'/contributing-results');?>">Projection</a>’ page,
                but
                your risk number will not change. Your risk
                profile might change in future, depending on your financial situation, your knowledge and your
                expectations. Contact your financial advisor for more information.</p>
            <dl class="uk-description-list uk-description-list-divider">
                <dt>Numbers 1 to 6</dt>
                <dd>A lower number indicates less need / ability / willingness to take risk. A higher number indicates
                    more need / ability / willingness to take risk. Different survey questions help us understand your
                    individual risk characteristics.</dd>
                <dt><img src="<?php echo assets_url('concerto/icons/icon-check.svg');?>" alt="Caution" width="22"
                        style="margin-top: -8px; position: inherit" /> Green tick</dt>
                <dd>Your survey responses indicate you are in this risk zone for this section of the survey.</dd>
                <dt><img src="<?php echo assets_url('concerto/icons/icon-warning.svg');?>" alt="Caution" width="22"
                        style="margin-top: -8px; position: inherit" /> Warning sign</dt>
                <dd>Your answers in this section do not match your overall risk profile. You may need to adjust your
                    expectations to give yourself the best chance of achieving your investment goals. We recommend
                    reviewing your results with a financial advisor.</dd>
                <dt>Background</dt>
                <dd>These questions help us understand how comfortable you are with investments, and how important your
                    JTC investment pot is as part of your overall wealth. The more experienced you are, the more likely
                    you are to be prepared to take on market risk. The smaller your pension plan as part of your overall
                    wealth, the more likely you are to take on market risk in this pot.</dd>
                <dt>Time Horizon</dt>
                <dd>A longer investment horizon means there is more time to make returns or recover losses. The longer
                    your horizon, all else equal, the more investment risk you are able to take.</dd>
                <dt>Growth</dt>
                <dd>Higher returns are a reward for market risk; if you expect higher growth, you will need to take on
                    more investment risk.</dd>
                <dt>Potential falls</dt>
                <dd>Your investments may fall in value as well as rise. The more you want to avoid falls, the less
                    market risk you should take on, particularly over a short horizon.</dd>
                <dt>Missing Out</dt>
                <dd>Do you suffer from FOMO? If you fear you will be left behind while others are making investment
                    returns, you are more likely to be prepared to take on risk in your investment portfolio.</dd>
                <dt>Liquidity</dt>
                <dd>Your cash-needs influence the investments which suit your goals. If you know you need cash soon, you
                    will fall into a lower risk profile as we expect you to take on less risk so you can preserve the
                    value of your investments and have them ready to liquidate quickly.</dd>
            </dl>
        </div>
        <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close  uk-border-pill" type="button">Close</button>
        </div>
    </div>
</div>