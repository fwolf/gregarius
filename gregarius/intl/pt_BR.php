<?php
###############################################################################
# Gregarius - A PHP based RSS aggregator.
# Copyright (C) 2003 - 2006 Marco Bonetti
#
###############################################################################
# This program is free software and open source software; you can redistribute
# it and/or modify it under the terms of the GNU General Public License as
# published by the Free Software Foundation; either version 2 of the License,
# or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful, but WITHOUT
# ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
# FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
# more details.
#
# You should have received a copy of the GNU General Public License along
# with this program; if not, write to the Free Software Foundation, Inc.,
# 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA  or visit
# http://www.gnu.org/licenses/gpl.html
#
###############################################################################
# E-mail:      eminetto at gmail dot com                
# Web page:    http://www.unochapeco.edu.br/~elm/
#
###############################################################################

/// Language: Portugu&ecirc;s
define ('LOCALE_WINDOWS','ptb');
define ('LOCALE_LINUX','pt_BR');

define ('LBL_ITEM','&iacute;tem');
define ('LBL_ITEMS','&iacute;tens');
define ('LBL_H2_SEARCH_RESULTS_FOR', "%d resultados para %s");
define ('LBL_H2_SEARCH_RESULT_FOR',"%d resultado para %s");
define ('LBL_H2_SEARCH', 'Buscar %d &iacute;tens');
define ('LBL_SEARCH_SEARCH_QUERY','Buscar termos:');
define ('LBL_SEARCH_MATCH_OR', 'Alguns termos (OU)');
define ('LBL_SEARCH_MATCH_AND', 'Todos os termos (E)');                                                                 
define ('LBL_SEARCH_MATCH_EXACT', 'Termo exato');
define ('LBL_SEARCH_CHANNELS', 'Feed:');
define ('LBL_SEARCH_ORDER_DATE_CHANNEL','Ordenar por data, feed');
define ('LBL_SEARCH_ORDER_CHANNEL_DATE','Ordenar por feed, data');
define ('LBL_SEARCH_RESULTS_PER_PAGE','Resultados por p&aacute;gina:');
define ('LBL_SEARCH_RESULTS','Resultados: ');
define ('LBL_H2_UNREAD_ITEMS','&Iacute;tens n&atilde;o lidos(<span id="ucnt">%d</span>)');
define ('LBL_H2_RECENT_ITEMS', "&Iacute;tens recentes");
define ('LBL_H2_CHANNELS','Feeds');
define ('LBL_H5_READ_UNREAD_STATS','%d &iacute;tens, %d n&atilde;o lidos');
define ('LBL_ITEMCOUNT_PF', '<strong>%d</strong> &iacute;tens (<strong>%d</strong> n&atilde;o lidos) em <strong>%d</strong> feeds');
define ('LBL_TAGCOUNT_PF', '<strong>%d</strong> &iacute;tens etiquetados items, em <strong>%d</strong> etiquetas');
define ('LBL_UNREAD_PF', '<strong id="%s" style="%s">(%d n&atilde;o lido)</strong>');
define ('LBL_UNREAD','n&atilde;o lido');

define ('LBL_FTR_POWERED_BY', " powered by ");
define ('LBL_ALL','All');
define ('LBL_NAV_HOME','<span>I</span>nicial');
define ('LBL_NAV_UPDATE', '<span>A</span>tualizar');
define ('LBL_NAV_CHANNEL_ADMIN', 'A<span>d</span>min');
define ('LBL_NAV_SEARCH', "<span>B</span>usca");
define ('LBL_SEARCH_GO', 'Busca');

define ('LBL_POSTED', 'Postado: ');
define ('LBL_FETCHED','Buscado: ');
define ('LBL_BY', ' por ');

define ('LBL_AND','e');

define ('LBL_TITLE_UPDATING','Atualizado');
define ('LBL_TITLE_SEARCH','Buscar');


define ('LBL_HOME_FOLDER','Root');
define ('LBL_VISIT', '(visite)');
define ('LBL_COLLAPSE','[-] contrair');
define ('LBL_EXPAND','[+] expandir');
define ('LBL_PL_FOR','Link permanente para ');

define ('LBL_UPDATE_CHANNEL','Feed');
define ('LBL_UPDATE_STATUS','Situa&ccedil;&atilde;o');
define ('LBL_UPDATE_UNREAD','Novos &Iacute;tens');

define ('LBL_UPDATE_STATUS_OK','OK (HTTP 200)');
define ('LBL_UPDATE_STATUS_CACHED', 'OK (Cache local)');
define ('LBL_UPDATE_STATUS_ERROR','ERRO');
define ('LBL_UPDATE_H2','Atualizando %d Feeds...');
define ('LBL_UPDATE_CACHE_TIMEOUT','HTTP Timeout (Cache local)');
define ('LBL_UPDATE_NOT_MODIFIED','OK (304 N&atilde;o modificado)');
define ('LBL_UPDATE_NOT_FOUND','404 N&atilde;o encontrado (Cache local)');
// admin
define ('LBL_ADMIN_EDIT', 'editar');
define ('LBL_ADMIN_DELETE', 'excluir');
define ('LBL_ADMIN_DELETE2', 'Excluir');
define ('LBL_ADMIN_RENAME', 'Renomear para...');
define ('LBL_ADMIN_CREATE', 'Criar');
define ('LBL_ADMIN_IMPORT','Importar');
define ('LBL_ADMIN_EXPORT','Exportar');
define ('LBL_ADMIN_DEFAULT','padr&atilde;o');
define ('LBL_ADMIN_ADD','Adicionar');
define ('LBL_ADMIN_YES', 'Sim');
define ('LBL_ADMIN_NO', 'N&atilde;o');
define ('LBL_ADMIN_FOLDERS','Pastas:');
define ('LBL_ADMIN_CHANNELS','Feeds:');
define ('LBL_ADMIN_OPML','OPML:');  
define ('LBL_ADMIN_ITEM','&Iacute;tens:');
define ('LBL_ADMIN_CONFIG','Configura&ccedil;&atilde;o:');
define ('LBL_ADMIN_OK','OK');
define ('LBL_ADMIN_CANCEL','Cancelar');
define ('LBL_ADMIN_LOGOUT','Sair');

define ('LBL_ADMIN_OPML_IMPORT','Importar');
define ('LBL_ADMIN_OPML_EXPORT','Exportar');
define ('LBL_ADMIN_OPML_IMPORT_OPML','Importar OPML:');
define ('LBL_ADMIN_OPML_EXPORT_OPML','Exportar OPML:');
define ('LBL_ADMIN_OPML_IMPORT_FROM_URL','... da URL:');
define ('LBL_ADMIN_OPML_IMPORT_FROM_FILE','... do Arquivo:');
define ('LBL_ADMIN_FILE_IMPORT','Importar arquivo');

define ('LBL_ADMIN_IN_FOLDER','para a pasta:');
define ('LBL_ADMIN_SUBMIT_CHANGES', 'Enviar Mudan&ccedil;as');
define ('LBL_ADMIN_PREVIEW_CHANGES','Preview');
define ('LBL_ADMIN_CHANNELS_HEADING_TITLE','T&iacute;tulo');
define ('LBL_ADMIN_CHANNELS_HEADING_FOLDER','Pasta');
define ('LBL_ADMIN_CHANNELS_HEADING_DESCR','Descri&ccedil;&atilde;o');
define ('LBL_ADMIN_CHANNELS_HEADING_MOVE','Mover');
define ('LBL_ADMIN_CHANNELS_HEADING_ACTION','A&ccedil;&atilde;o');
define ('LBL_ADMIN_CHANNELS_HEADING_FLAGS','Flags');
define ('LBL_ADMIN_CHANNELS_HEADING_KEY','Chave');
define ('LBL_ADMIN_CHANNELS_HEADING_VALUE','Valor');
define ('LBL_ADMIN_CHANNELS_ADD','Adicionar um feed:');
define ('LBL_ADMIN_FOLDERS_ADD','Adicionar uma pasta:');
define ('LBL_ADMIN_CHANNEL_ICON','Mostrar favicon:');
define ('LBL_CLEAR_FOR_NONE','(Deixe em branco para n&atilde;o usar &iacute;cone)');

define ('LBL_ADMIN_CONFIG_VALUE','Valor');

define ('LBL_ADMIN_PLUGINS_HEADING_NAME','Nome');
define ('LBL_ADMIN_PLUGINS_HEADING_AUTHOR','Autor');
define ('LBL_ADMIN_PLUGINS_HEADING_VERSION','Vers&atilde;o');
define ('LBL_ADMIN_PLUGINS_HEADING_DESCRIPTION','Descri&ccedil;&atilde;o');
define ('LBL_ADMIN_PLUGINS_HEADING_ACTION','Ativo');


define ('LBL_ADMIN_CHANNEL_EDIT_CHANNEL','Editar a feed ');
define ('LBL_ADMIN_CHANNEL_NAME','T&iacute;tulo:');
define ('LBL_ADMIN_CHANNEL_RSS_URL','RSS URL:');
define ('LBL_ADMIN_CHANNEL_SITE_URL','Site URL:');
define ('LBL_ADMIN_CHANNEL_FOLDER','Na pasta:');
define ('LBL_ADMIN_CHANNEL_DESCR','Descri&ccedil;&atilde;o:');
define ('LBL_ADMIN_FOLDER_NAME','Nome da pasta:');
define ('LBL_ADMIN_CHANNEL_PRIVATE','Este feed é <strong>privado</strong>, somente administradores podem v&ecirc;-lo.');
define ('LBL_ADMIN_CHANNEL_DELETED','Este feed é <strong>depreciado</strong>, ele n&atilde;o deve ser mais atualizado e n&atilde;o deve ser vis&iacute;vel na coluna de feeds.');

define ('LBL_ADMIN_ARE_YOU_SURE', "Voc&ecirc; tem certeza que deseja excluir  '%s'?");
define ('LBL_ADMIN_ARE_YOU_SURE_DEFAULT','Voc&ecirc; tem certeza que deseja reiniciar o valor de %s para seu padr&atilde;o \'%s\'?');
define ('LBL_ADMIN_TRUE','Verdadeiro');
define ('LBL_ADMIN_FALSE','Falso');
define ('LBL_ADMIN_MOVE_UP','&uarr;');
define ('LBL_ADMIN_MOVE_DOWN','&darr;');
define ('LBL_ADMIN_ADD_CHANNEL_EXPL','(Entre ou a URL de um RSS feed ou um Website cujo feed voc&ecirc; deseja assinar)');
define ('LBL_ADMIN_FEEDS','Os seguintes feeds foram encontrados em <a href="%s">%s</a>, qual deles voc&ecirc; deseja assinar?');

define ('LBL_ADMIN_PRUNE_OLDER','Excluir &iacute;tens mais velhos que ');
define ('LBL_ADMIN_PRUNE_DAYS','dias');
define ('LBL_ADMIN_PRUNE_MONTHS','meses');
define ('LBL_ADMIN_PRUNE_YEARS','anos');
define ('LBL_ADMIN_PRUNE_KEEP','Mantenha os &iacute;tens mais recentes: ');
define ('LBL_ADMIN_PRUNE_INCLUDE_STICKY','Excluir &iacute;tens Pregados também: ');
define ('LBL_ADMIN_PRUNE_EXCLUDE_TAGS','N&atilde;o excluir &iacute;tens etiquetados... ');
define ('LBL_ADMIN_ALLTAGS_EXPL','(Entre <strong>*</strong> para manter todos os &iacute;tens etiquetados)');

define ('LBL_ADMIN_ABOUT_TO_DELETE','Alerta: voc&ecirc; est&aacute; prestes a excluir %s &iacute;tens (de %s)');
define ('LBL_ADMIN_PRUNING','Podando');
define ('LBL_ADMIN_DOMAIN_FOLDER_LBL','pastas');
define ('LBL_ADMIN_DOMAIN_CHANNEL_LBL','feeds');
define ('LBL_ADMIN_DOMAIN_ITEM_LBL','&iacute;tens');
define ('LBL_ADMIN_DOMAIN_CONFIG_LBL','configura&ccedil;&atilde;o');
define ('LBL_ADMIN_DOMAIN_LBL_OPML_LBL','opml');
define ('LBL_ADMIN_BOOKMARKET_LABEL','Bookmarklet de assinatura[<a href="http://www.squarefree.com/bookmarklets/">?</a>]:');
define ('LBL_ADMIN_BOOKMARKLET_TITLE','Assinar Gregarius!');


define ('LBL_ADMIN_ERROR_NOT_AUTHORIZED', 
 		"<h1>N&atilde;o autorizado!</h1>\nVoc&ecirc; n&atilde;o est&aacute; autorizado a acessar a interface de administra&ccedil;&atilde;o.\n"
		."Por favor sigua <a href=\"%s\">este link</a> para voltar a p&aacute;gina principal.\n"
		."Tenha um bom dia!");
		
define ('LBL_ADMIN_ERROR_PRUNING_PERIOD','Per&iacute;odo de exclus&atilde;o inv&aacute;lido');
define ('LBL_ADMIN_ERROR_NO_PERIOD','oops, n&atilde;o foi especificado um per&iacute;odo');
define ('LBL_ADMIN_BAD_RSS_URL',"Sinto muito, eu acho que n&atilde;o posso tratar esta URL: '%s'");
define ('LBL_ADMIN_ERROR_CANT_DELETE_HOME_FOLDER',"Voc&ecirc; n&atilde;o pode excluir a pasta " . LBL_HOME_FOLDER . "");
define ('LBL_ADMIN_CANT_RENAME',"Voc&ecirc; n&atilde;o pode renomear a pasta '%s' porque tal pasta j&aacute; existe.");
define('LBL_ADMIN_ERROR_CANT_CREATE',"Parace que voc&ecirc; j&aacute; tem uma pasta chamada '%s'!");

define ('LBL_TAG_TAGS','Etiquetas');
define ('LBL_TAG_EDIT','editar');
define ('LBL_TAG_SUBMIT','submeter');
define ('LBL_TAG_CANCEL','cancelar');
define ('LBL_TAG_SUBMITTING','...');
define ('LBL_TAG_ERROR_NO_TAG',"Oops! Nenhum &iacute;tem etiquetado &laquo;%s&raquo; foi encontrado.");
define ('LBL_TAG_ALL_TAGS','Todas as etiquetas');
define ('LBL_TAG_TAGGED','etiquetado');
define ('LBL_TAG_TAGGEDP','etiquetado');
define ('LBL_TAG_SUGGESTIONS','sugest&otilde;es');
define ('LBL_TAG_SUGGESTIONS_NONE','sem sugest&otilde;es');
define ('LBL_TAG_RELATED','Etiquetas relacionadas: ');

define ('LBL_SHOW_UNREAD_ALL_SHOW','Mostrar &iacute;tens: ');
define ('LBL_SHOW_UNREAD_ALL_UNREAD_ONLY','N&atilde;o lidos apenas');
define ('LBL_SHOW_UNREAD_ALL_READ_AND_UNREAD','Lidos e n&atilde;o lidos');

define ('LBL_STATE_UNREAD','N&atilde;o lido (Altere o estado deste &iacute;tem para lido/n&atilde;o lido)');
define ('LBL_STATE_STICKY','Pregado (N&atilde;o excluir quando limpando &iacute;tens)');
define ('LBL_STATE_PRIVATE','Privado (Apenas administradores podem &iacute;tens privados)');
define ('LBL_STICKY','Pregado');
define ('LBL_DEPRECATED','Depreciado');
define ('LBL_PRIVATE','Privado');
define ('LBL_ADMIN_STATE','Estado:');
define ('LBL_ADMIN_STATE_SET','Mudar');
define ('LBL_ADMIN_IM_SURE','Eu tenho certeza!');

// new in 0.5.1:
define ('LBL_LOGGED_IN_AS','Logado como <strong>%s</strong>');
define ('LBL_NOT_LOGGED_IN','N&atilde;o logado');
define ('LBL_LOG_OUT','Sair');
define ('LBL_LOG_IN','Entrar');


define ('LBL_ADMIN_OPML_IMPORT_AND','Importar novas not&iacute;cias e:');
define ('LBL_ADMIN_OPML_IMPORT_WIPE','... substituir todas as not&iacute;cias e &iacute;tens.');
define ('LBL_ADMIN_OPML_IMPORT_FOLDER','... adicion&aacute;-las a pasta:');
define ('LBL_ADMIN_OPML_IMPORT_MERGE','... mescl&aacute;-las com as existentes.');

define ('LBL_ADMIN_OPML_IMPORT_FEED_INFO','Adicionando %s para %s... ');

define ('LBL_TAG_FOLDERS','Categorias');
define ('LBL_SIDE_ITEMS','(%d &iacute;tens)');
define ('LBL_SIDE_UNREAD_FEEDS','(%d n&atilde;o lidos em %d not&iacute;cias)');
define ('LBL_CATCNT_PF', '<strong>%d</strong> not&iacute;cias em <strong>%d</strong> categorias');

define ('LBL_RATING','Avalia&ccedil;&atilde;o:');
// New in 0.5.3:
// TRANSLATION NEEDED! Please join gregarius-i18n: http://sinless.org/mailman/listinfo/gregarius-i18n
define('LBL_ENCLOSURE', 'Cercado:');
define('LBL_DOWNLOAD', 'download');
define('LBL_PLAY', 'tocar');

define('LBL_FOOTER_LAST_MODIF_NEVER', 'Nunca');
define ('LBL_ADMIN_DASHBOARD','Prancheta');


define ('LBL_ADMIN_MUST_SET_PASS','<p>Nenhum administrador foi especificado ainda!</p>'
		.'<p>Por favor forne�a um usu&aacute;rio e senha para o Administrador agora!</p>');
define ('LBL_USERNAME','Usu&aacute;rio');		
define ('LBL_PASSWORD','Senha');
define ('LBL_PASSWORD2','Senha (novamente)');
define ('LBL_ADMIN_LOGIN','Por favor entre');
define ('LBL_ADMIN_PASS_NO_MATCH','Senhas n�o conferem!');

define ('LBL_ADMIN_PLUGINS','Plugins');
define ('LBL_ADMIN_DOMAIN_PLUGINS_LBL','plugins');
define ('LBL_ADMIN_PLUGINS_HEADING_OPTIONS','Op&ccedil;&otilde;es');
define ('LBL_ADMIN_PLUGINS_OPTIONS','Op&ccedil;&otilde;es de Plugins');
define ('LBL_ADMIN_CHECK_FOR_UPDATES','Verificar atualiza&ccedil;&otilde;es');
define ('LBL_ADMIN_LOGIN_BAD_LOGIN','<strong>Oops!</strong> Senha ou usu&aacute;rio inv�lido');
define ('LBL_ADMIN_LOGIN_NO_ADMIN','<strong>Oops!</strong> Voc&ecirc; entrou com sucesso '
			.'como %s, mas voc&ecirc; n&atilde;o tem privil&eacute;gios administrativos. Por favor entre novamente '
			.'com privil&eacute;gios administrativos ou volte para o <a href="..">&iacute;n&iacute;cio</a>');


define ('LBL_ADMIN_PLUGINS_GET_MORE', '<p style="font-size:small">'
.'Plugins s&atilde;o scripts fornecidos por terceiros que oferecem funcionalidades extras. '
.'Mais plugins podem ser encontrados no <a style="text-decoration:underline" '
.' href="http://plugins.gregarius.net/">Reposit&oacute;rio de Plugins</a>.</p>');


define ('LBL_LAST_UPDATE','&Uacute;ltima atualiza&ccedil;&atilde;o');						
define ('LBL_ADMIN_DOMAIN_THEMES_LBL','temas');
define ('LBL_ADMIN_THEMES','Temas');
define('LBL_ADMIN_ACTIVE_THEME','Tema ativo');
define('LBL_ADMIN_USE_THIS_THEME','Usar este Tema');
define('LBL_ADMIN_CONFIGURE','Configurar');
define('LBL_ADMIN_THEME_OPTIONS','Op&ccedil;&otilde;es do Tema');

define ('LBL_ADMIN_THEMES_GET_MORE', '<p style="font-size:small">'
.'Temas s&atilde;o feitos de um conjunto de arquivos de modelos que especificam como sua instala&ccedil;&atilde;o do Gregarius vai se parecer.<br />'
.'Mais temas podem ser encontrados no  <a style="text-decoration:underline" '
.' href="http://themes.gregarius.net/">Reposit&oacute;rio de Temas</a>.</p>');

define ('LBL_STATE_FLAG','Flag (Marca um &iacute;tem para leitura posterior)');
define ('LBL_FLAG','Marcado');

define ('LBL_MARK_READ', "Marcar todos os &iacute;tens como lidos");
define ('LBL_MARK_CHANNEL_READ', "Marcar este feed como lido");
define ('LBL_MARK_FOLDER_READ',"Marcar esta pasta como lida");

define ('LBL_MARK_CHANNEL_READ_ALL', "Marcar este feed como lido");
define ('LBL_MARK_FOLDER_READ_ALL',"Marcar esta pasta como lida");
define ('LBL_MARK_CATEGORY_READ_ALL',"Marcar esta categoria como lida");
?>