<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Emailtemp 
{
	public function ForgotPasswordTemplate($receiver_full_name,$receiver_id,$add_timestamp,$expiry_timestamp)
	{
		$hash = 'The quick brown fox jumps over the lazy dog';
		$reset_link = base_url('login/ResetPassword?link=').base64_encode($receiver_id.$hash.$add_timestamp.$expiry_timestamp);
		$html = '';
		$html .='<!DOCTYPE html>
		<html lang="en">
		<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="keywords" content="">
		<meta name="robots" content="all">
		<title>Wincation</title>
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,600italic,700,700italic,800" rel="stylesheet" type="text/css">
		</head>
		<body style="background-color:#F4F5FA;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed;background-color:#F4F5FA" id="bodyTable">
			<tbody>
				<tr>
					<td style="padding-right:10px;padding-left:10px;" align="center" valign="top" id="bodyCell">
						<table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapperWebview" style="max-width:600px">
							<tbody>
								<tr>
									<td align="center" valign="top">
										<table border="0" cellpadding="0" cellspacing="0" width="100%">
											<tbody>
												<tr>
													<td style="padding-top: 20px; padding-bottom: 20px; padding-right: 0px;" align="center" valign="middle">';
													$html .='<a href="'.base_url().'">Payone</a>';
													$html .='</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
						<table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapperBody" style="max-width:600px">
							<tbody>
								<tr>
									<td align="center" valign="top">
										<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableCard" style="background-color:#fff;border-color:#e5e5e5;border-style:solid;border-width:0 1px 1px 1px;">
											<tbody>
												<tr>
													<td style="background-color:#0c62d6;font-size:1px;line-height:3px" class="topBorder" height="3">&nbsp;</td>
												</tr>
												
												<tr>
													<td style="padding-bottom: 20px;" align="center" valign="top" class="imgHero">
														
													</td>
												</tr>
												<tr>
													<td style="padding-bottom: 20px;" align="center" valign="top" class="imgHero">
														
													</td>
												</tr>
												<tr>
													<td style="padding-bottom: 5px; padding-left: 20px; padding-right: 20px;" align="center" valign="top" class="mainTitle">
														<h2 class="text" style="color:#000;font-family:Poppins,Helvetica,Arial,sans-serif;font-size:28px;font-weight:500;font-style:normal;letter-spacing:normal;line-height:36px;text-transform:none;text-align:center;padding:0;margin:0">Reset Password</h2>
													</td>
												</tr>
												<tr>
													<td style="padding-bottom: 30px; padding-left: 20px; padding-right: 20px;" align="center" valign="top" class="subTitle">
														<h4 class="text" style="color:#999;font-family:Poppins,Helvetica,Arial,sans-serif;font-size:16px;font-weight:500;font-style:normal;letter-spacing:normal;line-height:24px;text-transform:none;text-align:center;padding:0;margin:0"></h4>
													</td>
												</tr>
												<tr>
													<td style="padding-left:20px;padding-right:20px" align="center" valign="top" class="containtTable ui-sortable">
														<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDescription" style="">
															<tbody>
																<tr>
																	<td style="padding-bottom: 20px;" align="center" valign="top" class="description">
																		<p class="text" style="color:#666;font-family:Open Sans,Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;font-style:normal;letter-spacing:normal;line-height:22px;text-transform:none;text-align:center;padding:0;margin:0">
																			Hi '.$receiver_full_name.', Please visit the link below to Reset Your Password<br>
																			This link will expire in 5 hours
																		</p>
																	</td>
																</tr>
															</tbody>
														</table>
														<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableButton" style="">
															<tbody>
																<tr>
																	<td style="padding-top:20px;padding-bottom:20px" align="center" valign="top">
																		<table border="0" cellpadding="0" cellspacing="0" align="center">
																			<tbody>
																				<tr>
																					<td style="background-color: #0c62d6; padding: 12px 35px; border-radius: 50px;" align="center" class="ctaButton"> <a href="'.$reset_link.'" target="_blank" style="color:#fff;font-family:Poppins,Helvetica,Arial,sans-serif;font-size:13px;font-weight:600;font-style:normal;letter-spacing:1px;line-height:20px;text-transform:uppercase;text-decoration:none;display:block" class="text">Reset Your Password</a>
																					</td>
																				</tr>
																			</tbody>
																		</table>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td style="font-size:1px;line-height:1px" height="20">&nbsp;</td>
												</tr>
											</tbody>
										</table>
										<table border="0" cellpadding="0" cellspacing="0" width="100%" class="space">
											<tbody>
												<tr>
													<td style="font-size:1px;line-height:1px" height="30">&nbsp;</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
						<table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapperFooter" style="max-width:600px">
							<tbody>
								<tr>
									<td align="center" valign="top">
										<table border="0" cellpadding="0" cellspacing="0" width="100%" class="footer">
											<tbody>
												
												<tr>
													<td style="padding: 10px 10px 5px;" align="center" valign="top" class="brandInfo">
														<p class="text" style="color:#666;font-family:Open Sans,Helvetica,Arial,sans-serif;font-size:12px;font-weight:400;font-style:normal;letter-spacing:normal;line-height:20px;text-transform:none;text-align:center;padding:0;margin:0">&copy; 2019 All Rights Reserved</p>
													</td>
												</tr>
												<tr>
													<td style="padding: 0px 10px 10px;" align="center" valign="top" class="footerEmailInfo">
														<p class="text" style="color:#666;font-family:Open Sans,Helvetica,Arial,sans-serif;font-size:12px;font-weight:400;font-style:normal;letter-spacing:normal;line-height:20px;text-transform:none;text-align:center;padding:0;margin:0">If you have any question please contact us <a href="mailto: support@wincation.com" style="color:#0f6cb2;text-decoration:underline" target="_blank">support@wincation.com</a>
															</p>
													</td>
												</tr>
												<tr>
													<td style="font-size:1px;line-height:1px" height="30">&nbsp;</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
								<tr>
									<td style="font-size:1px;line-height:1px" height="30">&nbsp;</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
			</table>
		</body>
		</html>';
		return $html;
	}
	public function ResetPasswordTemplate($receiver_full_name)  
	{ 
		$reset_link = base_url('login');
		$html = '';
		$html .='<!DOCTYPE html>
		<html lang="en">
		<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="keywords" content="">
		<meta name="robots" content="all">
		<title>Wincation</title>
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,600italic,700,700italic,800" rel="stylesheet" type="text/css">
		</head>
		<body style="background-color:#F4F5FA;">
			<table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed;background-color:#F4F5FA" id="bodyTable">
			<tbody>
				<tr>
					<td style="padding-right:10px;padding-left:10px;" align="center" valign="top" id="bodyCell">
						<table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapperWebview" style="max-width:600px">
							<tbody>
								<tr>
									<td align="center" valign="top">
										<table border="0" cellpadding="0" cellspacing="0" width="100%">
											<tbody>
												<tr>
													<td style="padding-top: 20px; padding-bottom: 20px; padding-right: 0px;" align="center" valign="middle">';
													$html .='<a href="'.base_url().'">Payone</a>';
													$html .='</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
						<table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapperBody" style="max-width:600px">
							<tbody>
								<tr>
									<td align="center" valign="top">
										<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableCard" style="background-color:#fff;border-color:#e5e5e5;border-style:solid;border-width:0 1px 1px 1px;">
											<tbody>
												<tr>
													<td style="background-color:#0c62d6;font-size:1px;line-height:3px" class="topBorder" height="3">&nbsp;</td>
												</tr>
												
												<tr>
													<td style="padding-bottom: 20px;" align="center" valign="top" class="imgHero">
														
													</td>
												</tr>
												<tr>
													<td style="padding-bottom: 20px;" align="center" valign="top" class="imgHero">
														
													</td>
												</tr>
												<tr>
													<td style="padding-bottom: 5px; padding-left: 20px; padding-right: 20px;" align="center" valign="top" class="mainTitle">
														<h2 class="text" style="color:#000;font-family:Poppins,Helvetica,Arial,sans-serif;font-size:28px;font-weight:500;font-style:normal;letter-spacing:normal;line-height:36px;text-transform:none;text-align:center;padding:0;margin:0">Reset Password</h2>
													</td>
												</tr>
												<tr>
													<td style="padding-bottom: 30px; padding-left: 20px; padding-right: 20px;" align="center" valign="top" class="subTitle">
														<h4 class="text" style="color:#999;font-family:Poppins,Helvetica,Arial,sans-serif;font-size:16px;font-weight:500;font-style:normal;letter-spacing:normal;line-height:24px;text-transform:none;text-align:center;padding:0;margin:0"></h4>
													</td>
												</tr>
												<tr>
													<td style="padding-left:20px;padding-right:20px" align="center" valign="top" class="containtTable ui-sortable">
														<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDescription" style="">
															<tbody>
																<tr>
																	<td style="padding-bottom: 20px;" align="center" valign="top" class="description">
																		<p class="text" style="color:#666;font-family:Open Sans,Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;font-style:normal;letter-spacing:normal;line-height:22px;text-transform:none;text-align:center;padding:0;margin:0">
																			Hi '.$receiver_full_name.', Your password is reset successfully!<br>
																			Please visit the link below to continue
																		</p>
																	</td>
																</tr>
															</tbody>
														</table>
														<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableButton" style="">
															<tbody>
																<tr>
																	<td style="padding-top:20px;padding-bottom:20px" align="center" valign="top">
																		<table border="0" cellpadding="0" cellspacing="0" align="center">
																			<tbody>
																				<tr>
																					<td style="background-color: #0c62d6; padding: 12px 35px; border-radius: 50px;" align="center" class="ctaButton"> <a href="'.$reset_link.'" target="_blank" style="color:#fff;font-family:Poppins,Helvetica,Arial,sans-serif;font-size:13px;font-weight:600;font-style:normal;letter-spacing:1px;line-height:20px;text-transform:uppercase;text-decoration:none;display:block" class="text">Please Login To Continue</a>
																					</td>
																				</tr>
																			</tbody>
																		</table>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td style="font-size:1px;line-height:1px" height="20">&nbsp;</td>
												</tr>
											</tbody>
										</table>
										<table border="0" cellpadding="0" cellspacing="0" width="100%" class="space">
											<tbody>
												<tr>
													<td style="font-size:1px;line-height:1px" height="30">&nbsp;</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
						<table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapperFooter" style="max-width:600px">
							<tbody>
								<tr>
									<td align="center" valign="top">
										<table border="0" cellpadding="0" cellspacing="0" width="100%" class="footer">
											<tbody>
												
												<tr>
													<td style="padding: 10px 10px 5px;" align="center" valign="top" class="brandInfo">
														<p class="text" style="color:#666;font-family:Open Sans,Helvetica,Arial,sans-serif;font-size:12px;font-weight:400;font-style:normal;letter-spacing:normal;line-height:20px;text-transform:none;text-align:center;padding:0;margin:0">&copy; 2019 All Rights Reserved</p>
													</td>
												</tr>
												<tr>
													<td style="padding: 0px 10px 10px;" align="center" valign="top" class="footerEmailInfo">
														<p class="text" style="color:#666;font-family:Open Sans,Helvetica,Arial,sans-serif;font-size:12px;font-weight:400;font-style:normal;letter-spacing:normal;line-height:20px;text-transform:none;text-align:center;padding:0;margin:0">If you have any question please contact us <a href="mailto: support@wincation.com" style="color:#0f6cb2;text-decoration:underline" target="_blank">support@wincation.com</a>
															</p>
													</td>
												</tr>
												<tr>
													<td style="font-size:1px;line-height:1px" height="30">&nbsp;</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
								<tr>
									<td style="font-size:1px;line-height:1px" height="30">&nbsp;</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
			</table>
		</body>
		</html>';
		return $html;
	}
}