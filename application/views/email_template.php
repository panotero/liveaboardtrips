<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Email Notification</title>
</head>

<body style="margin:0; padding:0; background-color:#f7fafc; font-family: Arial, sans-serif;">

	<table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f7fafc" style="padding:20px 0;">
		<tr>
			<td align="center">
				<table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:600px; background-color:#ffffff; border-radius:8px; border-collapse:separate;">
					<tr>
						<td style="padding:24px;">
							<!-- Header -->
							<h1 style="font-size:24px; font-weight:bold; color:#2d3748; margin:0;">
								<?php echo $header ?? ''; ?>
							</h1>
							<?php if (isset($ref_code)) { ?>
								<p style="margin-top:10px; font-size:14px; color:#718096;">Booking Reference: <?php echo $ref_code; ?></p>
							<?php } ?>

							<!-- Message -->
							<p style="margin-top:16px; font-size:14px; line-height:1.6; color:#718096;">
								<?php echo $message ?? ''; ?>
							</p>

							<?php if (isset($breakdown)) { ?>
								<!-- Breakdown Section -->
								<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:24px; background-color:#f9f9f9; padding:16px; border:1px solid #e2e8f0; border-radius:8px;">
									<tr>
										<td colspan="2" style="text-align:center; font-size:16px; font-weight:bold; color:#2d3748; padding-bottom:12px;">
											Breakdown of Fees
										</td>
									</tr>
									<?php
									$total = 0;
									foreach ($breakdown as $item) {
									?>
										<tr>
											<td style="font-size:14px; color:#2d3748; padding:8px 0; border-bottom:1px solid #e2e8f0;">
												<?php
												echo $item['cabin_name'];
												if ($item['accommodation'] == 1) {
													echo ' (Solo Accommodation) + ' . $item['surcharge_percent'] . '% Surcharge';
												}
												?>
											</td>
											<td align="right" style="font-size:14px; color:#3182ce; font-weight:bold; padding:8px 0; border-bottom:1px solid #e2e8f0;">
												$<?php echo number_format($item['base_price']); ?>
											</td>
										</tr>
									<?php
										$total += $item['base_price'];
									}
									?>
									<tr>
										<td style="padding-top:16px; font-size:16px; font-weight:bold; color:#2d3748;">Total</td>
										<td align="right" style="padding-top:16px; font-size:16px; font-weight:bold; color:#3182ce;">
											$<?php echo number_format($total); ?>
										</td>
									</tr>
								</table>

								<!-- Pay Now Button -->
								<?php if (isset($ref_code)) { ?>
									<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:24px;">
										<tr>
											<td align="center">
												<a href="<?php echo base_url('payment?ref_code=') . $ref_code; ?>" style="display:inline-block; padding:12px 24px; background-color:rgb(110, 218, 100); color:#ffffff; text-decoration:none; font-weight:bold; border-radius:8px; font-size:16px;">
													Pay Now
												</a>
											</td>
										</tr>
									</table>
								<?php } ?>
							<?php } ?>

							<!-- Footer -->
							<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:32px; border-top:1px solid #e2e8f0; padding-top:16px;">
								<tr>
									<td align="center">
										<img src="<?php echo base_url('assets/img/liveaboardtripsLOGO.png'); ?>" alt="Logo" style="height:48px; display:block; margin:0 auto;">
										<p style="margin-top:8px; font-size:12px; color:#a0aec0;">© 2025 LiveAboardTrips.com. All rights reserved.</p>
									</td>
								</tr>
							</table>

						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

</body>

</html>
