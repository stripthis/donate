  <div class="landing_page">
    <h2><?php echo __('Donate', true)."\n"; ?></h2>
<p class="decoration"><?php echo __('Join Greenpeace today and add your voice to the movement that\'s committed to defending our planet. Our vision of a better future is only as strong as the people who support us. Your support will make all the difference.!', true); ?></p>
<h3><?php echo __('Choose An Appeal!', true); ?></h3>
<ul>
<?php foreach ($appeals as $appeal) : ?>
	<li>
		<?php
		echo $html->link($appeal['Appeal']['name'], array(
			'controller' => 'gifts', 'action' => 'add', 'appeal_id' => $appeal['Appeal']['slug']
		));
		?>
	</li>
<?php endforeach ?>
</ul>
<h3><?php echo __('Default forms', true); ?></h3>
<ul>
<li><a href="http://www.greenpeace.org/africa/donate?referrer=indexgpi" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Africa</a></li>
<li><a href="https://unite.greenpeace.org.ar/?referrer=gpi_splash_web" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Argentina</a></font></li>
<li><a href="http://www.greenpeace.org/australia/donate" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Australia Pacific</a></li>
<li><a href="http://www.greenpeace.at/spenden.html" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Austria</a></li>
<li><a href="http://secure.greenpeace-be.eu/nl_blue" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Belgium (Dutch)</a></li>
<li><a href="http://secure.greenpeace-be.eu/fr_blue" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Belgium (French)</a> </li>
<li><a href="https://junte-se-ao-greenpeace.org.br/" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Brazil</a></li>
<li><a href="http://www.greenpeace.org/canada/en/support-greenpeace" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Canada (English)</a></li>
<li><a href="https://www.strategicprofitsinc.com/greenpeace/fr/" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Canada (French)</a></li>
<li><a href="https://www.greenpeace.com/chile/contrib.html" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Chile</a></li>
<li><a href="http://www.greenpeace.org/china/en/SupportUs" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">China</a></li>
<li><a href="http://www.greenpeace.cz/podporte/prihlaska.shtml" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Czech Republic</a></li>
<li><a href="http://www.greenpeace.org/denmark/stot-os/" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Denmark</a></li>
<li><a href="http://www.greenpeace.org/finland/fi/tue" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Finland</a></li>
<li><a href="http://www.greenpeace.org/finland/se/support" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Finland (Swedish)</a></li>
<li><a href="http://www.greenpeace.fr/soutien/index.htm" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">France</a> </li>
<li><a href="https://service.greenpeace.de/ueber_uns/spenden/spenden_sie_online/?bannerid=140500000404000" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Germany</a></li>
<li><a href="http://www.greenpeace.org/greece/support-us" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Greece</a></li>
<li><a href="http://www.greenpeace.hu/index.php?m=tamogat&amp;alm=5&amp;PHPSESSID=ee0ac074aed5ada3d80476953c0823ba" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Hungary</a></li>
<li><a href="http://www.greenpeace.in/donate.php" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">India</a></li>
<li><a href="http://www.donategreenpeace.org/" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Indonesia</a></li>
<li><a href="http://archive.greenpeace.org/forms/gpidebit.htm" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Ireland</a></li>
</ul>
<ul>
<li><a href="https://www.greenpeace.com/donation/donate.php?installation_id=israel" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Israel</a></li>
<li><a href="http://www.greenpeace.it/sostieni" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Italy</a></li>
<li><a href="https://www.greenpeace.or.jp/credit-en.html" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Japan</a></li>
<li><a href="http://www.greenpeace.org/lebanon/ar/supportus/donate" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Lebanon</a></li>
<li><a href="http://www.greenpeace.org/luxembourg/rejoignez-nous" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Luxembourg</a></li>
<li><a href="http://www.greenpeace.org/mexico/unete" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Mexico</a></li>
<li><a href="https://www.greenpeace.org.nz/join/join.asp" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">New Zealand</a></li>
<li><a href="https://secure.greenpeaceweb.org/macht_index.asp?broncode=0660" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Netherlands</a></li>
<li><a href="http://www.greenpeace.org/norway/supportus/stott-oss-online" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Norway</a></li>
<li><a href="http://www.donategreenpeace.org/" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Philippines</a></li>
<li><a href="http://www.greenpeace.org/poland/wesprzyj-nas/przelewy-online" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Poland</a></li>
<li><a href="http://join.greenpeace.ru/" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Russia (Russian)</a> </li>
<li><a href="http://join.greenpeace.ru/index_eng.phtml" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Russia (English)</a></li>
<li><a href="http://web.greenpeace.sk/sup.htm" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Slovakia</a></li>
<li><a href="https://colabora2.greenpeace.es/" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Spain</a></li>
<li><a href="http://www.greenpeace.org/sweden/stoed-oss" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Sweden</a></li>
<li><a href="http://www.greenpeace.ch/de/spenden/donation/mitgliedschaft/spendenbetrag/?utm_source=gpi&amp;utm_medium=supportus" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Switzerland (German)</a></li>
<li><a href="http://www.greenpeace.ch/fr/dons/dons-adhesion/" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Switzerland (French)</a></li>
<li><a href="http://www.donategreenpeace.org/" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Thailand</a></li>
<li><a href="http://www.greenpeace.org/turkey/kat-l-n" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">Turkey</a></li>
<li><a href="http://www.greenpeace.org.uk/donate" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">United Kingdom</a></li>
<li><a href="https://secureusa.greenpeace.org/securedonate/index.php?from=gpi" onclick="javascript: pageTracker._trackPageview('/outbound/main/donate/'+this.text);">United States</a></li>
</ul>

</div>