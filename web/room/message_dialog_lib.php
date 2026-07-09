<div id="carbonVideoNotice" style="
	display: none;
	position: fixed;
	top: 20px;
	right: 20px;
	z-index: 99999;
	background: linear-gradient(135deg, #1f2937, #111827);
	color: white;
	padding: 16px 18px;
	border-radius: 12px;
	box-shadow: 0 8px 24px rgba(0,0,0,0.35);
	max-width: 430px;
	font-size: 14px;
	align-items: flex-start;
	gap: 14px;
	border-left: 5px solid #22c55e;
">
	<div style="flex-shrink: 0; width: 48px; height: 48px;">
		<svg viewBox="0 0 64 64" width="48" height="48" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
			<defs>
				<linearGradient id="camBody" x1="0" y1="0" x2="1" y2="1">
					<stop offset="0%" stop-color="#34d399"/>
					<stop offset="100%" stop-color="#16a34a"/>
				</linearGradient>
				<linearGradient id="leafGrad" x1="0" y1="0" x2="1" y2="1">
					<stop offset="0%" stop-color="#86efac"/>
					<stop offset="100%" stop-color="#15803d"/>
				</linearGradient>
			</defs>

			<circle cx="32" cy="32" r="30" fill="#ecfdf5"/>
			<rect x="12" y="20" rx="8" ry="8" width="28" height="20" fill="url(#camBody)"/>
			<polygon points="40,25 52,20 52,40 40,35" fill="#10b981"/>
			<circle cx="24" cy="30" r="5" fill="#d1fae5"/>
			<circle cx="24" cy="30" r="2.5" fill="#065f46"/>
			<path d="M30 42c10-14 22-12 22-12s1 14-13 22c-5 3-12-1-9-10z" fill="url(#leafGrad)"/>
			<path d="M33 45c4-3 9-8 15-14" stroke="#166534" stroke-width="2.5" fill="none" stroke-linecap="round"/>
		</svg>
	</div>

	<div style="flex: 1;">
		<div style="
			font-size: 15px;
			font-weight: 700;
			margin-bottom: 6px;
			color: #bbf7d0;
		">
			<?php print $lang['VIDEO_MSG_TITLE']?>
		</div>
		<div style="
			line-height: 1.45;
			color: #e5e7eb;
		">
			<?php print $lang['VIDEO_MSG_BODY']?>
		</div>
	</div>

	<button id="closeCarbonVideoNotice" style="
		background: transparent;
		border: none;
		color: #9ca3af;
		font-size: 18px;
		cursor: pointer;
		padding: 0;
		line-height: 1;
		flex-shrink: 0;
	" aria-label="Close">&times;</button>
</div>