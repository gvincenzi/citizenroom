                    <div class="card-header text-center">
						<div class="logo" id="title"><a href="/web/join">CitizenRoom</a></div>
						<div id="primary-navigation-menu">
							<nav>
								<ul class="nav justify-content-center">
									<nav classname="nav-item">
										<ul>
											<li class="nav-link"><a href="/web/join" class="link menu-link"><?php print $lang['PUBLIC_ROOM']?></a></li>
											<li class="nav-link"><a href="/web/join/?room_type=custom" class="link menu-link"><?php print $lang['CUSTOM_ROOM']?></a></li>
											<li class="nav-item dropdown">
												<a class="link menu-link dropdown-toggle" href="#" id="dropdown1" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php print $lang['TOPIC_ROOM']?></a>
												<ul class="dropdown-menu dropdown-menu-dark">
													<li><a class="dropdown-item dropdown-item-topic" href="#"><b><?php print $lang['TOPIC_ROOM_PARLIAMENT']?></b></a></li>
													<li><a class="dropdown-item" href="/web/topic/parliament"><?php print $lang['TOPIC_ROOM_PARLIAMENT_EUROPE']?></a></li>
													<li><a class="dropdown-item" href="/web/topic/parliament?country=france"><?php print $lang['TOPIC_ROOM_PARLIAMENT_FRANCE']?></a></li>
													<li><a class="dropdown-item" href="/web/topic/parliament?country=italy"><?php print $lang['TOPIC_ROOM_PARLIAMENT_ITALY']?></a></li>
													<li><hr class="dropdown-divider"></li>
													<li><a class="dropdown-item dropdown-item-topic" href="#"><b><?php print $lang['TOPIC_ROOM_MUNICIPALITY']?></b></a></li>
													<li><a class="dropdown-item" href="/web/topic/municipality?country=france"><?php print $lang['TOPIC_ROOM_MUNICIPALITY_FRANCE']?></a></li>
													<li><a class="dropdown-item" href="/web/topic/municipality?country=italy"><?php print $lang['TOPIC_ROOM_MUNICIPALITY_ITALY']?></a></li>
												</ul>
											</li>
											<li class="nav-link"><a href="/web/what" class="link menu-link"><?php print $lang['ABOUT']?></a></li>
											<li class="nav-link"><a href="/web/privacy" class="link menu-link">Privacy (italian language)</a></li>
										</ul>
									</nav>
								</ul>
							</nav>
						</div>
						<div id='callbackMessage'></div>
						<div id='loginAlert'></div>
						<?php
							if(isset($_SESSION["login.error"])){
								print '<div class="alert alert-danger">'.$_SESSION["login.error"].'</div>';
							}
						?>
					</div>