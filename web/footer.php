	<footer>
		<div align="center">
        	<a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-sa/4.0/88x31.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/StillImage" property="dct:title" rel="dct:type">CitizenRoom Logo</span> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/">Creative Commons Attribution-ShareAlike 4.0 International License</a>.<br>
        	Press contact : <a href="mailto:a23@altervista.org">citizenroom (at) altervista (dot) org</a> | <a href="../privacy"> Privacy (italian language)</a>| <a href="../what"> Info (italian language)</a><br>
			<?php 
			 if(isset($_GET['type'])){
				print_r('<a id="biz" href="../join"> CitizenRoom</a>');
			 } else {
				print_r('<a id="biz" href="../login?type=business"> CitizenRoom for business</a>');
			 } 
			?>
			
			
		</div>
	</footer>