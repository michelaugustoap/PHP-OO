<?php
//inclui a clase TTranslation
include_once 'app.widgets/TTranslation.class.php';

//define a linguagem como potuguês
TTranslation::setLanguage('pt');
echo "Em Português <br>\n";
		
		//imprime palavras traduzidas
		echo _t('Function') . "<br>\n";
		echo _t('Table') . "<br>\n";
		echo _t('Tool') . "<br>\n";
		
//define a linguagem como italiado
TTranslation::setLanguage('it');
echo "Em Italiano<br/>\n";

//imprime palavras traduzidas
		echo _t('Function') . "<br>\n";
		echo _t('Table') . "<br>\n";
		echo _t('Tool') . "<br>\n";