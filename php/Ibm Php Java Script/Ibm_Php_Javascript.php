<?php
include($admin_folder_name.'/plugins/productGallery/ps_pagination.php');
$gtask = '';
if(!important())
{
	echo $error;
	exit;
}
function trunc($phrase,$start_words, $max_words)

{

   $phrase_array = explode(' ',$phrase);

   if(count($phrase_array) > $max_words && $max_words > 0)

      $phrase = implode(' ',array_slice($phrase_array, $start_words, $max_words)).'...';  

   return $phrase;

}

function categoryRecursion($cat_id,$plugin_id,$exmenu,$gtask)
{
	global $db,$admin_folder_name;
	
	$get_data = mysql_fetch_array(mysql_query("SELECT * FROM gallery_category WHERE id = ".$cat_id));
	if($cat_id == 0)
	{
		$value = '<a href="index.php?plugin_id='.$plugin_id.'&exmenu='.$exmenu.'&gtask=category&cat_id='.$cat_id.'">Product Gallery</a>';
		return $value;
	}
	else
	{
		$value = '&raquo; <a href="index.php?plugin_id='.$plugin_id.'&exmenu='.$exmenu.'&gtask=category&cat_id='.$cat_id.'" >'.stripslashes($get_data['cat_name']).'</a> ';
		return categoryRecursion($get_data['parent'],$plugin_id,$exmenu,$gtask)." ".$value;
	}
}


		$get_style_data = mysql_query("SELECT * FROM gallery_manager WHERE g_id = 1") or die(mysql_error());
		$get_style = mysql_fetch_array($get_style_data);
		
		$get_image_data = mysql_query("SELECT * FROM image_manager WHERE id = 1") or die(mysql_error());
		$get_image = mysql_fetch_array($get_image_data);
	
	if(!important())
	{
		echo $error;
		exit;
	}							
?>

			
						<?php
							if(!empty($_REQUEST['gtask']))
							{
							$gtask = $_REQUEST['gtask'];
							}
							switch($gtask)
							{
								case 'category' :
									categoryList();
									break;
								case 'product' :
									productList();
									break;
								case 'details' :
									details();
									break;
								default :									
									productGallery();
									break;
							}
							
							
							function productGallery()
							{
								global $db,$get_style,$admin_folder_name,$get_image;
							
						?>			
									<table width="650" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#222325" >
                                          <tr>
                                            <td width="724" height="8"></td>
                                          </tr>
                                          
                                          <tr>
                                            <td class="plugin_title" style="color:#FFFFFF;">Catagory Home</td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td>
											<table width="650" border="0" cellspacing="0" cellpadding="0" >
                                             <tr align="center" >
											 <?php																					
																					
												$query = "SELECT * FROM gallery_category WHERE parent = 0 ORDER BY ".$get_style['cat_sort']." ".$get_style['cat_order'];
												
												
												//Create a PS_Pagination object
												$pager = new PS_Pagination($db,$query,$get_style['cat_no_per_page'],3,"plugin_id=".$_REQUEST['plugin_id']."&exmenu=".$_REQUEST['exmenu']."&");
												
												//The paginate() function returns a mysql result set 
												$data = $pager->paginate();
												
												$i = 1;
												while($arinfo = mysql_fetch_array($data)) 
												{
													$check_child = mysql_query("SELECT  * FROM gallery_category WHERE parent = ".$arinfo['id']);
													$check_product = mysql_query("SELECT  * FROM photos WHERE cat_id = ".$arinfo['id']);
													
											?>
						 <td width="240">
						 
						 <a href="index.php?plugin_id=<?php echo $_REQUEST['plugin_id']; ?>&exmenu=<?php echo $_REQUEST['exmenu']; ?>&gtask=<?php if(mysql_num_rows($check_product) > 0){ ?>product<?php }else { if(mysql_num_rows($check_child) <= 0){ ?>product<?php }else{ ?>category<?php } } ?>&cat_id=<?php echo $arinfo['id']; ?>" class="opacityit"><img src="<?php echo $admin_folder_name; ?>/images/gallery/category/<?php echo stripslashes($arinfo['cat_image']); ?>" <?php if(!empty($get_image['cat_img_width'])){ ?>width="<?php echo $get_image['cat_img_width']; ?>" <?php } if(!empty($get_image['cat_img_height'])){ ?> height="<?php echo $get_image['cat_img_height']; ?>" <?php } ?> border="0" class="border"/></a>
						 
						 
												<div  class="category_title" align="center" style="color:#FFFFFF;">
												<?php echo stripslashes($arinfo['cat_name']); ?>												</div>												</td>
                                                
                                             <?php
											 	if($i % $get_style['cat_col_no'] == 0)
												{
													echo '</tr><tr align="center">';
												}
								
											 	$i++;
											 	}
											 ?>
											  </tr>
											  
                                              <?php if(!empty($data ))
																{
																
																?>
																<tr>
																	  <td align="center" colspan="8" style="color:#000000" ><?php echo $pager->renderFirst()."  "; echo $pager->renderPrev()."   ";echo $pager->renderNav()."        "; echo $pager->renderNext()."    ";echo $pager->renderLast()."     ";  ?></td>
														  </tr> 	
																 <?php
															}
																 ?>
                                            </table></td>
                                          </tr>
                                          <tr>
                                            <td>											</td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                          </tr>
										  
										  
										  <?php
										  	$latest_on = $get_style['latest_pro_on'];
										  	if($latest_on == 1 && important())
											{
										  ?>
                                          <tr>
                                            <td class="plugin_title" style="color:#FFFFFF;">Latest Product </td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td>
											<table width="650" border="0" cellspacing="0" cellpadding="0">
                                             <tr align="center">
											 <?php																					
																					
												$latest_query = "SELECT * FROM photos ORDER BY ".$get_style['latest_pro_sort']." ".$get_style['latest_pro_order']." LIMIT ".$get_style['latest_pro_no_per_page'];
												
												
												$latestProduct = mysql_query($latest_query) or die(mysql_error());
												
												$i = 1;
												while($arinfo = mysql_fetch_array($latestProduct)) 
												{
													
											?>
											 
                                                <td width="240"><a href="index.php?plugin_id=<?php echo $_REQUEST['plugin_id']; ?>&exmenu=<?php echo $_REQUEST['exmenu']; ?>&gtask=details&cat_id=<?php echo $arinfo['cat_id']; ?>&product_id=<?php echo $arinfo['id']; ?>" class="opacityit"><img src="<?php echo $admin_folder_name; ?>/images/gallery/thumb/<?php echo stripslashes($arinfo['image_thumb']); ?>" <?php if(!empty($get_image['pro_img_thumb_width'])){ ?>width="<?php echo $get_image['pro_img_thumb_width']; ?>"<?php } if(!empty($get_image['pro_img_thumb_height'])){  ?> height="<?php echo $get_image['pro_img_thumb_height']; ?>"<?php } ?> border="0" class="border"/></a>
													<div  class="category_title" align="center" style="color:#FFFFFF;">
													<?php echo stripslashes($arinfo['image_title']); ?>													</div>													</td>
                                                
                                             <?php
											 	if($i % 3 == 0)
												{
													echo '</tr><tr align="center">';
												}
								
											 	$i++;
											 	}
											 ?>
											  </tr>
                                            </table></td>
                                          </tr>
                                          <?php
										  	}
										  ?>
										  
										  
										  <?php
										  	$featured_on = $get_style['featured_pro_on'];
										  	if($featured_on == 1 && important())
											{
										  ?>
                                          <tr>
                                            <td class="plugin_title" style="color:#FFFFFF;">Featured Product </td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td>
											<table width="650" border="0" cellspacing="0" cellpadding="0">
                                             <tr align="center">
											 <?php																					
																					
												$featured_query = "SELECT * FROM photos WHERE featured = 1 ORDER BY ".$get_style['featured_pro_sort']." ".$get_style['featured_pro_order']." LIMIT ".$get_style['featured_pro_no_per_page'];
												
												
												$featuredProduct = mysql_query($featured_query) or die(mysql_error());
												
												$i = 1;
												while($arinfo = mysql_fetch_array($featuredProduct)) 
												{
													
											?>
											 
                                                <td width="240"><a href="index.php?plugin_id=<?php echo $_REQUEST['plugin_id']; ?>&exmenu=<?php echo $_REQUEST['exmenu']; ?>&gtask=details&cat_id=<?php echo $arinfo['cat_id']; ?>&product_id=<?php echo $arinfo['id']; ?>" class="opacityit"><img src="<?php echo $admin_folder_name; ?>/images/gallery/thumb/<?php echo stripslashes($arinfo['image_thumb']); ?>" <?php if(!empty($get_image['pro_img_thumb_width'])){ ?>width="<?php echo $get_image['pro_img_thumb_width']; ?>"<?php } if(!empty($get_image['pro_img_thumb_height'])){ ?> height="<?php echo $get_image['pro_img_thumb_height']; ?>"<?php } ?> border="0" class="border"/></a>
													<div  class="category_title" align="center" style="color:#FFFFFF;">
													<?php echo stripslashes($arinfo['image_title']); ?>													</div>													</td>
                                                
                                             <?php
											 	if($i % 3 == 0)
												{
													echo '</tr><tr align="center">';
												}
								
											 	$i++;
											 	}
											 ?>
											  </tr>
                                            </table></td>
                                          </tr>
                                          <?php
										  	}
										  ?>
										  
										  <?php
										  	$featured_cat_on = $get_style['fearured_cat_on'];
										  	if($featured_cat_on == 1 && important())
											{
										  ?>
                                          <tr>
                                            <td class="plugin_title" style="color:#FFFFFF;">Featured Category </td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td>
											<table width="650" border="0" cellspacing="0" cellpadding="0">
                                             <tr align="center">
											 <?php																					
																					
												$featured_query = "SELECT * FROM gallery_category WHERE featured = 1 ORDER BY ".$get_style['fearured_cat_sort']." ".$get_style['fearured_cat_order']." LIMIT ".$get_style['fearured_cat_no_per_page'];
												
												
												$featuredCat = mysql_query($featured_query) or die(mysql_error());
												
												$i = 1;
												while($arinfo = mysql_fetch_array($featuredCat)) 
												{
												
													$check_child = mysql_query("SELECT  * FROM gallery_category WHERE parent = ".$arinfo['id']);
													
													
											?>
											 
                                                 <td width="240"><a href="index.php?plugin_id=<?php echo $_REQUEST['plugin_id']; ?>&exmenu=<?php echo $_REQUEST['exmenu']; ?>&gtask=<?php if(mysql_num_rows($check_child) > 0){ ?>category<?php }else{ ?>product<?php } ?>&cat_id=<?php echo $arinfo['id']; ?>" class="opacityit"><img src="<?php echo $admin_folder_name; ?>/images/gallery/category/<?php echo stripslashes($arinfo['cat_image']); ?>" <?php if(!empty($get_image['cat_img_width'])){ ?> width="<?php echo $get_image['cat_img_width']; ?>"<?php }  if(!empty($get_image['cat_img_height'])){ ?> height="<?php echo $get_image['cat_img_height']; ?>"<?php } ?> border="0" class="border"/></a>
												<div  class="category_title" align="center" style="color:#FFFFFF;">
												<?php echo stripslashes($arinfo['cat_name']); ?>												</div>												</td>
                                                
                                             <?php
											 	if($i % 3 == 0)
												{
													echo '</tr><tr align="center">';
												}
								
											 	$i++;
											 	}
											 ?>
											  </tr>
                                            </table></td>
                                          </tr>
                                          <?php
										  	}
										  ?>
										  
										  
										  <?php
										  	$latest_cat_on = $get_style['latest_cat_on'];
										  	if($latest_cat_on == 1 && important())
											{
										  ?>
                                          <tr>
                                            <td class="plugin_title" style="color:#FFFFFF;">Latest Category </td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td>
											<table width="650" border="0" cellspacing="0" cellpadding="0">
                                             <tr align="center">
											 <?php																					
																					
												$featured_query = "SELECT * FROM gallery_category ORDER BY ".$get_style['latest_cat_sort']." ".$get_style['latest_cat_order']." LIMIT ".$get_style['latest_cat_no_per_page'];
												
												
												$featuredCat = mysql_query($featured_query) or die(mysql_error());
												
												$i = 1;
												while($arinfo = mysql_fetch_array($featuredCat)) 
												{
												
													$check_child = mysql_query("SELECT  * FROM gallery_category WHERE parent = ".$arinfo['id']);
													
													
											?>
											 
                                                 <td width="240"><a href="index.php?plugin_id=<?php echo $_REQUEST['plugin_id']; ?>&exmenu=<?php echo $_REQUEST['exmenu']; ?>&gtask=<?php if(mysql_num_rows($check_child) > 0){ ?>category<?php }else{ ?>product<?php } ?>&cat_id=<?php echo $arinfo['id']; ?>" class="opacityit"><img src="<?php echo $admin_folder_name; ?>/images/gallery/category/<?php echo stripslashes($arinfo['cat_image']); ?>" <?php if(!empty($get_image['cat_img_width'])){ ?> width="<?php echo $get_image['cat_img_width']; ?>"<?php } if(!empty($get_image['cat_img_height'])){ ?> height="<?php echo $get_image['cat_img_height']; ?>"<?php } ?> border="0" class="border"/></a>
												<div  class="category_title" align="center" style="color:#FFFFFF;">
												<?php echo stripslashes($arinfo['cat_name']); ?>												</div>												</td>
                                                
                                             <?php
											 	if($i % 3 == 0)
												{
													echo '</tr><tr align="center">';
												}
								
											 	$i++;
											 	}
											 ?>
											  </tr>
                                            </table></td>
                                          </tr>
                                          <?php
										  	}
										  ?>
                        </table>
								<?php
								}
								
								function categoryList()
								{
									global $db,$get_style,$admin_folder_name,$get_image;
								?>
									<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
                                          <tr>
                                            <td height="8"></td>
                                          </tr>
                                          <tr>
                                            <td>
												<?php
												$cat_id = $_REQUEST['cat_id'];
														$get_category = mysql_fetch_array(mysql_query("SELECT * FROM gallery_category WHERE id = '$cat_id' "));
												?>
											</td>
                                          </tr>
                                          <tr>
                                            <td class="link_3"><!--<a href="index.php?plugin_id=<?php echo $_REQUEST['plugin_id']; ?>&exmenu=<?php echo $_REQUEST['exmenu']; ?>">Product Gallery</a> &raquo; --> <?php echo categoryRecursion($cat_id,$_REQUEST['plugin_id'],$_REQUEST['exmenu'],''); ?> </td>
                                          </tr>
                                          <tr>
                                            <td style="border-bottom:1px solid #999966; border-bottom-style:dashed;">&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td class="plugin_title" style="color:#FFFFFF;"><?php echo stripslashes($get_category['cat_name']); ?> </td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td><table width="650" border="0" cellspacing="0" cellpadding="0">
                                              <tr align="center">
											  
												<?php																					
																						
													$query = "SELECT * FROM gallery_category WHERE parent = '$cat_id' ORDER BY ".$get_style['cat_sort']." ".$get_style['cat_order'];
													
													
													//Create a PS_Pagination object
													$pager = new PS_Pagination($db,$query,$get_style['cat_no_per_page'],3,"plugin_id=".$_REQUEST['plugin_id']."&exmenu=".$_REQUEST['exmenu']."&gtask=".$_REQUEST['gtask']."&cat_id=".$cat_id."&");
													
													//The paginate() function returns a mysql result set 
													$data = $pager->paginate();
													
													$i = 1;
													while($arinfo = mysql_fetch_array($data)) 
													{
														$check_child = mysql_query("SELECT  * FROM gallery_category WHERE parent = ".$arinfo['id']);
														$check_product = mysql_query("SELECT  * FROM photos WHERE cat_id = ".$arinfo['id']);
												?>
												 
													<td width="240" style="color:#FFFFFF;"><a href="index.php?plugin_id=<?php echo $_REQUEST['plugin_id']; ?>&exmenu=<?php echo $_REQUEST['exmenu']; ?>&gtask=<?php if(mysql_num_rows($check_product) > 0){ ?>product<?php }else {  if(mysql_num_rows($check_child) <= 0){ ?>product<?php }else{ ?>category<?php } } ?>&cat_id=<?php echo $arinfo['id']; ?>" class="opacityit"><img src="<?php echo $admin_folder_name; ?>/images/gallery/category/<?php echo stripslashes($arinfo['cat_image']); ?>" <?php if(!empty($get_image['cat_img_width'])){ ?> width="<?php echo $get_image['cat_img_width']; ?>"<?php } if(!empty($get_image['cat_img_height'])){ ?> height="<?php echo $get_image['cat_img_height']; ?>"<?php } ?> border="0" class="border"/></a>
													<div  class="category_title" align="center" style="color:#FFFFFF;">
													<?php echo stripslashes($arinfo['cat_name']); ?>
													</div>
													</td>
													
												 <?php
													if($i % $get_style['cat_col_no'] == 0)
													{
														echo '</tr><tr align="center">';
													}
									
													$i++;
													}
												 ?>
                                              </tr>
                                              <?php if(!empty($data ))
																{
																
																?>
																<tr>
																	  <td align="center" colspan="8" style="color:#000000" ><?php echo $pager->renderFirst()."  "; echo $pager->renderPrev()."   ";echo $pager->renderNav()."        "; echo $pager->renderNext()."    ";echo $pager->renderLast()."     ";  ?></td>
														  </tr> 	
																 <?php
															}
																 ?>
                                            </table></td>
                                          </tr>
                                          <tr>
                                            <td>											</td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                          </tr>
                                          
                                          
                                          

                        </table>
								<?php
								}
								
								function productList()
								{
									global $db,$get_style,$admin_folder_name,$get_image;
								?>
									<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
                                          <tr>
                                            <td height="8"></td>
                                          </tr>
                                          <tr>
                                            <td>
												<?php
												$cat_id = $_REQUEST['cat_id'];
														$get_category = mysql_fetch_array(mysql_query("SELECT * FROM gallery_category WHERE id = '$cat_id'"));
												?>											</td>
                                          </tr>
                                          <tr>
                                            <td class="link_3"><a href="index.php?plugin_id=<?php echo $_REQUEST['plugin_id']; ?>&exmenu=<?php echo $_REQUEST['exmenu']; ?>"><!--Product Gallery</a> &raquo; --> <?php echo categoryRecursion($get_category['parent'],$_REQUEST['plugin_id'],$_REQUEST['exmenu'],$_REQUEST['gtask']); ?> &raquo; <a href="index.php?plugin_id=<?php echo $_REQUEST['plugin_id']; ?>&exmenu=<?php echo $_REQUEST['exmenu']; ?>&gtask=product&cat_id=<?php echo $cat_id; ?>" ><?php echo stripslashes($get_category['cat_name']); ?></a></td>
                                          </tr>
                                          <tr>
                                            <td style="border-bottom:1px solid #999966; border-bottom-style:dashed;">&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td class="plugin_title" style="color:#FFFFFF;"><?php echo stripslashes($get_category['cat_name']); ?> </td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                          </tr>

		<!-- my, our product -->                                           
										  <tr>
                            <td valign="top" height="5"><img src="<?php echo $admin_folder_name; ?>/plugins/productGallery/images/003_43.gif" width="714" height="56" /></td>
                          </tr>
						 <tr>
                           <td background="<?php echo $admin_folder_name; ?>/plugins/productGallery/images/003_72.gif">&nbsp;</td>
                          </tr>
										  
										  <tr>
                                            <td background="<?php echo $admin_folder_name; ?>/plugins/productGallery/images/003_72.gif"><table align="center" width="650" border="0" cellspacing="0" cellpadding="0">
											
									
     
	 <tr align="center">
	 <td width="20%">&nbsp;  </td>
											  
												<?php																					
																						
													$query = "SELECT * FROM photos WHERE cat_id = '$cat_id' ORDER BY  ".$get_style['pro_sort']." ".$get_style['pro_order'];
													
													
													//Create a PS_Pagination object
													$pager = new PS_Pagination($db,$query,$get_style['pro_no_per_page'],3,"plugin_id=".$_REQUEST['plugin_id']."&exmenu=".$_REQUEST['exmenu']."&gtask=".$_REQUEST['gtask']."&cat_id=".$cat_id."&");
													
													//The paginate() function returns a mysql result set 
													$data = $pager->paginate();
													
													$i = 1;
													while($arinfo = mysql_fetch_array($data)) 
													{
														
												?>
						 
				<td style="color:#FFFFFF;" class="opacityit"><img src="<?php echo $admin_folder_name; ?>/images/gallery/thumb/<?php echo stripslashes($arinfo['image_thumb']); ?>" <?php if(!empty($get_image['pro_img_thumb_width'])){ ?>width="<?php echo $get_image['pro_img_thumb_width']; ?>"<?php } if(!empty($get_image['pro_img_thumb_height'])){ ?> height="<?php echo $get_image['pro_img_thumb_height']; ?>" <?php } ?> border="0"  />
				
				
		<div  align="right" style="width:216; background-color:#1A1A1A">				
			<a  href="index.php?plugin_id=<?php echo $_REQUEST['plugin_id']; ?>&exmenu=<?php echo $_REQUEST['exmenu']; ?>&gtask=details&cat_id=<?php echo $cat_id; ?>&product_id=<?php echo $arinfo['id']; ?>" >
			<img src="images/00231_73.jpg" width="68" height="12" />
			  </a>
				</div>
				
			<div  align="right" style="width:216; height:20px">				
				
				</div>							</td>								<!-- <div  class="category_title" align="center" style="color:#FFFFFF;"><span class="category_title" style="color:#FFFFFF;">< ?php echo stripslashes($arinfo['image_title']); ?></span></div> 		  
													-->
													
													
												
													
			<td width="20%">&nbsp;  </td>
												 <?php
													if($i % $get_style['pro_col_no'] == 0)
													{
														echo '</tr><tr align="center"><td width="20%"> &nbsp; </td>';
													}
									
													$i++;
													}
												 ?>
                                              </tr>
                                              <?php if(!empty($data ))
																{
																
																?>
																<tr>
																	  <td align="center" colspan="8" style="color:#000000" ><?php echo $pager->renderFirst()."  "; echo $pager->renderPrev()."   ";echo $pager->renderNav()."        "; echo $pager->renderNext()."    ";echo $pager->renderLast()."     ";  ?></td>
														  </tr> 	
																 <?php
															}
																 ?>
                    
											
											</table></td>
                                          </tr>
                                          <tr>
                                            <td>											</td>
                                          </tr>
                                          
                         <tr>
                            <td><img src="<?php echo $admin_folder_name; ?>/plugins/productGallery/images/003_73.gif" width="714" height="26" /></td>
                          </tr>                  
                        </table>
								<?php
								}
								function details()
								{
									global $db,$get_style,$admin_folder_name,$get_image;
								?>
									<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
                                          <tr>
                                            <td height="8"></td>
                                          </tr>
                                          <tr>
                                            <td>
												<?php
												$cat_id = $_REQUEST['cat_id'];
												$product_id = $_REQUEST['product_id'];
														$get_product = mysql_fetch_array(mysql_query("SELECT * FROM photos WHERE id = '$product_id'"));
														
														$get_category = mysql_fetch_array(mysql_query("SELECT * FROM gallery_category WHERE id = '$cat_id'"));
														
														
												?>
											</td>
                                          </tr>
                                          <tr>
                                            <td class="link_3"><a href="index.php?plugin_id=<?php echo $_REQUEST['plugin_id']; ?>&exmenu=<?php echo $_REQUEST['exmenu']; ?>"><!--Product Gallery</a> &raquo; --> <?php echo categoryRecursion($get_category['parent'],$_REQUEST['plugin_id'],$_REQUEST['exmenu'],$_REQUEST['gtask']); ?> &raquo; <a href="index.php?plugin_id=<?php echo $_REQUEST['plugin_id']; ?>&exmenu=<?php echo $_REQUEST['exmenu']; ?>&gtask=product&cat_id=<?php echo $cat_id; ?>" ><?php echo stripslashes($get_category['cat_name']); ?></a> &raquo; <?php echo stripslashes($get_product['image_title']); ?></td>
                                          </tr>
                                          
                                                                                
                                          <tr>
                                            <td>&nbsp;</td>
                                          </tr>
                                      
                                          <tr>
                                            <td>											</td>
                                          </tr>
                                          <tr>
                                            <td>
											
											<table width="710" border="0" align="right" cellpadding="0" cellspacing="0">
                          <tr>
                            <td height="14"></td>
                          </tr>
                          
                          <tr>
                            <td valign="top"><div align="center"><img src="images/007_03.gif" width="710" height="48" /></div></td>
                          </tr>
                          <tr>
                            <td valign="top" background="images/007_06.gif"><table width="673" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="330" valign="top" background="images/000_10.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td height="11"></td>
                                      </tr>
               <form method="post" name="myform1">
									  <tr>
                                        <td align="center" style="color:#FFFFFF;"><a href="<?php echo $admin_folder_name; ?>/images/gallery/big/<?php echo $get_product['image_name']; ?>" rel="lightbox[example]"><img name="mainimage" src="<?php echo $admin_folder_name; ?>/images/gallery/big/<?php echo $get_product['image_name']; ?>" <?php if(!empty($get_image['pro_img_big_width'])){ ?>width="<?php echo $get_image['pro_img_big_width']; ?>"<?php } if(!empty($get_image['pro_img_big_height'])){ ?> height="<?php echo $get_image['pro_img_big_height']; ?>"<?php } ?> border="0" class="border_1" /></a></td>
                                      </tr>
                                      <tr>
                                        <td height="11"></td>
                                      </tr>
                                    </table></td>
                                    <td width="11">&nbsp;</td>
                                    <td width="331" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      
                                      <tr>
                                        <td><img src="images/0000_09.gif" width="331" height="30" /></td>
                                      </tr>
                                      <tr>
                                        <td background="images/000_17.gif">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td height="342" background="images/000_17.gif" valign="top"><span class="plugin_title" style="color:#FFFFFF; margin-left:10px;"><?php echo stripslashes($get_product['image_title']); ?></span><br /> 
	          <div style="color:#FFFFFF; margin-left:20px;"><?php echo stripslashes($get_product['image_desc']); ?></div></td>
                                      </tr>
                                      <tr>
                                        <td><img src="images/000_20.gif" width="331" height="9" /></td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                </table></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td><img src="images/0000_17.gif" width="673" height="35" /></td>
                              </tr>
                              <tr>
                                <td background="images/fff_07.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td>&nbsp;</td>
                                  </tr>
								  
		  <tr>
			<td align="center">
			
						 
			  <table width="652" height="112" cellpadding="2" cellspacing="2">
			   <tr>
		 <script>
		  function abc(myid)
		  {
		  
		   //alert(myid); 
		  document.myform1.mainimage.src =  document.getElementById(myid).name;
		  }
		 </script>
		
		 
		 <?php 
		 $pro_id = $_REQUEST['product_id'];
		 $result = mysql_query("SELECT * FROM pro_photos WHERE pro_id = '$pro_id'") or die ("Image reading error.");
		 
		 while($pro_img = mysql_fetch_row($result) )
		 {
		 ?>
		 <td  width="80">
		  <img id="<?php echo $pro_img['0'];?>"  src="<?php echo $admin_folder_name . '/images/gallery/thumb/' . $pro_img['4']; ?>" width="80" height="100" name="<?php echo $admin_folder_name . '/images/gallery/big/' . $pro_img['4']; ?>" onclick="javascript: abc(this.id);" style="cursor:pointer;"/>
		 </td>
		 
		 <?php
		  } //end while
		 ?>
		 
			   </tr>
			  </table>
			 </form> 			  
			</td>
		  </tr>
				
				</table>                                  </td>
                              </tr>
                              <tr>
                                <td><img src="images/fff_14.jpg" width="673" height="9" /></td>
                              </tr>
                              
                              <tr>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td><img src="images/0000_24.gif" width="673" height="34" /></td>
                              </tr>
                              <tr>
                                <td  background="images/fff_07.jpg">&nbsp;</td>
                              </tr>
                              <tr>
                                <td height="40" background="images/fff_07.jpg">
                                  
                                  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="200" background="images/00231_76.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td><div align="center"><img src="images/2_54.jpg" width="177" height="216" /></div></td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td style="padding-right:15px;"><div align="right"><a href="#"><img src="images/00231_73.jpg" width="68" height="12" border="0" /></a></div></td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                          </tr>
                                      </table></td>
                                      <td>&nbsp;</td>
                                      <td width="200" background="images/00231_76.jpg">&nbsp;</td>
                                      <td>&nbsp;</td>
                                      <td width="200" background="images/00231_76.jpg">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td>&nbsp;</td>
                                      <td>&nbsp;</td>
                                      <td>&nbsp;</td>
                                      <td>&nbsp;</td>
                                      <td>&nbsp;</td>
                                    </tr>
                                  </table>                                  </td>
                              </tr>
                              <tr>
                                <td><img src="images/fff_14.jpg" width="673" height="9" /></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                              </tr>
                            </table></td>
                          </tr>
                          
                          <tr>
                            <td><div align="center"><img src="images/007_10.gif" width="710" height="26" /></div></td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
											
											</td>
                                          </tr>
                                         
                                       
                                          <tr>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td align="center">
													<table width="300" border="0" cellspacing="0" cellpadding="5">
												  <tr>
													<td width="24%" align="right">
													<?php if(!empty($_REQUEST['pg'])){ $pg = $_REQUEST['pg']; }else{ $pg = 1;  } 
														$get_prev_id = mysql_fetch_array(mysql_query("SELECT id FROM photos WHERE cat_id = '$cat_id' AND id < '$product_id' ORDER BY id DESC LIMIT 1"));
														if(!empty($get_prev_id['id']))
														{
													?>
													<a href="index.php?plugin_id=<?php echo $_REQUEST['plugin_id']; ?>&exmenu=<?php echo $_REQUEST['exmenu']; ?>&gtask=details&cat_id=<?php echo $cat_id; ?>&product_id=<?php echo $get_prev_id['id']; ?>&pg=<?php echo $pg; ?>"><strong><font color="#0066FF">Previous</font></strong></a>
													<?php
														}
													?>
													</td>
													<td width="29%" align="center"><a href="index.php?plugin_id=<?php echo $_REQUEST['plugin_id']; ?>&exmenu=<?php echo $_REQUEST['exmenu']; ?>&gtask=product&cat_id=<?php echo $cat_id; ?>&page=<?php echo $pg; ?>"><strong><font color="#0066FF">Go back</font></strong></a></td>
													<td width="47%" align="left">
													<?php
														$get_next_id = mysql_fetch_array(mysql_query("SELECT id FROM photos WHERE cat_id = '$cat_id' AND id > '$product_id' ORDER BY id ASC LIMIT 1"));
														if(!empty($get_next_id['id']))
														{
													?>
													<a href="index.php?plugin_id=<?php echo $_REQUEST['plugin_id']; ?>&exmenu=<?php echo $_REQUEST['exmenu']; ?>&gtask=details&cat_id=<?php echo $cat_id; ?>&product_id=<?php echo $get_next_id['id']; ?>&pg=<?php echo $pg; ?>"><strong><font color="#0066FF">Next</font></strong></a>
													<?php
														}
													?>
													</td>
												  </tr>
												</table>
											</td>
                                          </tr>
                                          <tr>
                                            <td>&nbsp;</td>
                                          </tr>
                                          
                                          
                                          

                        </table>
								<?php
								}
								?>