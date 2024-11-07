<div class="light-style input-small">
    <div class="account-text-block">
        <div class="account-title-block borderb spb">
            <div class="title-content va">
                <img width="52" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/faq.svg" alt="faq icon" />
                <h5>FAQ</h5>
            </div>
        </div>

        <form class="search-form search-form-pad va">
            <input type="text" id="search-value">
            <input type="submit" class="btn style2" value="SEARCH">
        </form>

        <div class="questions q-style2 mt30">

            <div id="question1" class="question">
                <div class="quest active-question">
                    <h6>General Information</h6>
                </div>
                <div class="answer-text">
                    <div class="answ-cont">
                        <div class="answ-content">
                            <p>The Synergy Network is a platform for solopreneurs, coaches, and service providers to exchange services using Synergy Francs (SF), a unique token system.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="question">
                <div class="quest">
                    <h6>Membership Plans</h6>
                </div>
                <div class="answer-text">
                    <div class="answ-cont">
                        <div class="answ-content">
                            <p>The Synergy Network is a platform for solopreneurs, coaches, and service providers to exchange services using Synergy Francs (SF), a unique token system.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="question">
                <div class="quest">
                    <h6>Synergy Francs (SF)</h6>
                </div>
                <div class="answer-text">
                    <div class="answ-cont">
                        <div class="answ-content">
                            <p>The Synergy Network is a platform for solopreneurs, coaches, and service providers to exchange services using Synergy Francs (SF), a unique token system.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="question">
                <div class="quest">
                    <h6>Service Listings</h6>
                </div>
                <div class="answer-text">
                    <div class="answ-cont">
                        <div class="answ-content">
                            <p>The Synergy Network is a platform for solopreneurs, coaches, and service providers to exchange services using Synergy Francs (SF), a unique token system.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="question">
                <div class="quest">
                    <h6>Transactions & Payments</h6>
                </div>
                <div class="answer-text">
                    <div class="answ-cont">
                        <div class="answ-content">
                            <ul>
                                <li>How do I pay for services?</li>
                                <li>How are transaction fees applied?</li>
                                <li>Can I view my transaction history?</li>
                                <li>What if I have a dispute with a service provider?</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="account-text-block">
        <div class="account-title-block spb">
            <div class="title-content va">
                <img width="52" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/support_tickets.svg" alt="support tickets icon" />
                <h5>Support Tickets</h5>
            </div>
        </div>

        <div class="block-lines small-lines media-full">

            <div class="block-line spb">
                <div class="line-left">
                    <p>Raise a New Ticket</p>
                </div>
                <div class="line-right width-field width2">
                    <div class="btn-block">
                        <a href="#" class="btn style2 w100" id="tsg-submit-ticket-btn">Raise a New Ticket</a>
                    </div>
                </div>
            </div>
            <div class="block-line spb" id="tsg-submit-ticket-container" style="display: none;"><?php echo do_shortcode('[submit_tickets]'); ?></div>    
            <div class="block-line spb">
                <div class="line-left">
                    <p>My Tickets</p>
                </div>
                <div class="line-right width-field width2">
                    <?php 
                        $args = array(
                            'post_type'      => 'emd_ticket', 
                            'post_status'    => 'publish', 
                            'posts_per_page' => -1, 
                            'fields'         => 'ids',
                            'author'         => get_current_user_id()  
                        );
                    
                        $tickets = new WP_Query($args);
                        $ticket_count = $tickets->found_posts;
                    ?>
                    <div class="btn-block">
                        <a href="#" class="btn style2 w100" id="tsg-active-tickets-btn"><?php echo $ticket_count; ?> active tickets</a>
                    </div>
                </div>
            </div>
            <div class="block-line spb" id="tsg-active-tickets-container" style="display: none;"><?php echo do_shortcode('[support_tickets]'); ?></div>
        </div>
    </div>

    <div class="account-text-block">
        <div class="account-title-block spb">
            <div class="title-content va">
                <img width="40" src="<?php echo THE_SYNERGY_GROUP_URL; ?>public/img/account/book.svg" alt="knowledge base icon" />
                <h5>Knowledge Base</h5>
            </div>
        </div>

        <div class="block-lines small-lines media-full">

            <div class="block-line spb">
                <div class="line-left">
                    <p>User Guides</p>
                </div>
                <div class="line-right width-field width2">
                    <div class="btn-block">
                        <a href="#" class="btn style2 w100">Read guides</a>
                    </div>
                </div>
            </div>

            <div class="block-line spb">
                <div class="line-left">
                    <p>Video Tutorials</p>
                </div>
                <div class="line-right width-field width2">
                    <div class="btn-block">
                        <a href="#" class="btn style2 w100">Watch videos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>