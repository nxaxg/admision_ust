<?php
    $email_contents = $GLOBALS['email_contents'];
    $email_origen   = $GLOBALS['email_origen'];
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $email_contents['title']; ?></title>
</head>
<body style="background: #ededed; padding: 0; margin: 0; font-family: sans-serif;" >

	<div id="header" style="display: block; width: 100%; background: #ffffff; text-align: center; padding: 40px 10px; border-top: 10px solid #008b83;" >
	<?php if( empty($email_origen['origen']) ) { ?>
		<img style="display: inline-block; max-width: 90%;" src="<?php bloginfo('template_directory'); ?>/images/logos/logo-admision-email.png">
	<?php } elseif( $email_origen['origen'] === 'formulario_contacto' ) { ?>
		<img style="display: inline-block; max-width: 90%;" src="<?php bloginfo('template_directory'); ?>/images/logos/logo-email.png">
	<?php } ?>
	</div>

	<div id="cuerpo" style="padding: 40px 0;" >
		<div style="background: #ffffff; padding: 40px; width: 600px; max-width: 100%; margin: 0 auto; box-sizing: border-box;" >
			<table style="border-collapse: collapse; width: 100%;" >
				<tr>
					<td>
						<h1 style="display: block; font-size: 14px; font-weight: bold; margin: 0 0 1.5em 0; color: #00354F;">
							<?php echo $email_contents['intro']; ?>
						</h1>

						<div style="display: block; font-size: 14px; color: #333; margin-bottom: 40px;" >
							<?php echo $email_contents['mensaje']; ?>

							<p>
								Saludos <br>
								<strong>Admisión Santo Tomás</strong>
							</p>
						</div>
						<p style="font-size: 11px;" >Por favor, no responda a este correo.</p>
					</td>
				</tr>
			</table>
		</div>
	</div>

	<div id="footer" style="display: block; width: 100%; background: #003B30; text-align: center; padding: 40px 10px;" >
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="100%" align="center" style="padding-bottom:10px; color:#ffffff; text-align:center; font-size: 12px;">
                    <p style="margin: 0;">Derechos reservados Santo Tomás.</p>
                    <p style="margin: 0;">Casa Central Av. Ejército, Barrio Universitario, Santiago.</p>
                </td>
            </tr>
        </table>
	</div>
</body>
</html>
