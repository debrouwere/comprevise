			<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
			<html>
			<head>
			<title>{title}</title>
			<meta content="charset" value="utf-8" />
			<style type="text/css">
			#concept{background: url('<?php echo '../' . $file; ?>') center top no-repeat;}
			</style>
			<link rel="stylesheet" type="text/css" media="screen" href="../../_resources/style.css">
			<link rel="stylesheet" type="text/css" media="screen" href="../../../_resources/style.css">
			<link rel="stylesheet" type="text/css" media="print" href="../../_resources/print.css" />
			<link rel="stylesheet" type="text/css" media="print" href="../../../_resources/print.css" />
			<script language="javascript">
            function hidenav() {
				document.getElementById('header-bar').style.display = "none";
				document.getElementById('concept').style.top = (0)+'px';
			}
			</script>
			</head>
			
			<body id="conceptview">
			<ul id="header-bar">
				<li<?php if($prev==''){echo ' class="disabled"';} ?>><a href="<?php if($prev==''){echo '#';}else{echo $prev;} ?>">&larr; Previous Concept</a></li>
				<li><a href="<?php echo $up_lvl; ?>">Back to Project Dashboard</a></li>
				<li<?php if($next==''){echo ' class="disabled"';} ?>><a href="<?php if($next==''){echo '#';}else{echo $next;} ?>">Next Concept &rarr;</a></li>
			<li><a href="#" onclick="hidenav()" style="position: absolute; top: 10px; right: 30px;">X</a></li>
			</ul>
			
			<div id="concept"> 
			<img src="../{$file}" />
			</div>
			</body>
			</html>