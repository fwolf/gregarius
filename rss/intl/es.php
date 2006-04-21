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
# E-mail:      godsea at gmail dot com
# Web page:    http://godsea.dsland.org
#
###############################################################################


/// Language: Espa&ntilde;ol
define ('LOCALE_WINDOWS','esp');
define ('LOCALE_LINUX','es_ES');

define ('LBL_ITEM','tema');
define ('LBL_ITEMS','temas');
define ('LBL_H2_SEARCH_RESULTS_FOR', "%d encontrados de %s");
define ('LBL_H2_SEARCH_RESULT_FOR',"%d encontrado de %s");
define ('LBL_H2_SEARCH', 'Buscar %d temas');
define ('LBL_SEARCH_SEARCH_QUERY','Buscar palabras:');
define ('LBL_SEARCH_MATCH_OR', 'Alguna palabra');
define ('LBL_SEARCH_MATCH_AND', 'Todas las palabras');                                                                 
define ('LBL_SEARCH_MATCH_EXACT', 'Busqueda exacta');
define ('LBL_SEARCH_CHANNELS', 'Canal:');
define ('LBL_SEARCH_ORDER_DATE_CHANNEL','Ordenar por fecha, tema');
define ('LBL_SEARCH_ORDER_CHANNEL_DATE','Ordenar por tema, fecha');
define ('LBL_SEARCH_RESULTS_PER_PAGE','Resultados por pagina:');
define ('LBL_SEARCH_RESULTS','Resultados: ');
define ('LBL_H2_UNREAD_ITEMS','temas sin leer (<span id="ucnt">%d</span>)');
define ('LBL_H2_RECENT_ITEMS', "temas recientes");
define ('LBL_H2_CHANNELS','Canales');
define ('LBL_H5_READ_UNREAD_STATS','%d temas, %d sin leer');
define ('LBL_ITEMCOUNT_PF', '<strong>%d</strong> temas (<strong>%d</strong> sin leer) en <strong>%d</strong> canales');
define ('LBL_TAGCOUNT_PF', '<strong>%d</strong> temas con tag, <strong>%d</strong> tags');
define ('LBL_UNREAD_PF', '<strong id="%s" style="%s">(%d sin leer)</strong>');
define ('LBL_UNREAD','sin leer');

define ('LBL_FTR_POWERED_BY', " desarrollado con ");
define ('LBL_ALL','Todos');
define ('LBL_NAV_HOME','<span>I</span>nicio');
define ('LBL_NAV_UPDATE', '<span>A</span>ctualizar');
define ('LBL_NAV_CHANNEL_ADMIN', 'A<span>d</span>ministrar');
define ('LBL_NAV_SEARCH', "Bu<span>s</span>cador");
define ('LBL_SEARCH_GO', 'Buscar');

define ('LBL_POSTED', 'Archivado: ');
define ('LBL_FETCHED','Actualizado: ');
define ('LBL_BY', ' por ');

define ('LBL_AND','y');

define ('LBL_TITLE_UPDATING','Actualizando');
define ('LBL_TITLE_SEARCH','Buscador');


define ('LBL_HOME_FOLDER','Raiz');
define ('LBL_VISIT', '(visitado)');
define ('LBL_COLLAPSE','[-] recoger');
define ('LBL_EXPAND','[+] expandir');
define ('LBL_PL_FOR','Enlace permanente para ');

define ('LBL_UPDATE_CHANNEL','Canal');
define ('LBL_UPDATE_STATUS','Estado');
define ('LBL_UPDATE_UNREAD','Nuevos temas');

define ('LBL_UPDATE_STATUS_OK','OK');
define ('LBL_UPDATE_STATUS_CACHED', 'OK (Cache local)');
define ('LBL_UPDATE_STATUS_ERROR','ERROR');
define ('LBL_UPDATE_H2','Actualizando %d temas...');
define ('LBL_UPDATE_CACHE_TIMEOUT','No se pudo recuperar (Cache local)');
define ('LBL_UPDATE_NOT_MODIFIED','OK (Sin modificaciones)');
define ('LBL_UPDATE_NOT_FOUND','No encontrado (Cache local)');
// admin
define ('LBL_ADMIN_EDIT', 'editar');
define ('LBL_ADMIN_DELETE', 'eliminar');
define ('LBL_ADMIN_DELETE2', 'Eliminar');
define ('LBL_ADMIN_RENAME', 'Renombrar a...');
define ('LBL_ADMIN_CREATE', 'Crear');
define ('LBL_ADMIN_IMPORT','Importar');
define ('LBL_ADMIN_EXPORT','Exportar');
define ('LBL_ADMIN_DEFAULT','predeterminado');
define ('LBL_ADMIN_ADD','Enviar');
define ('LBL_ADMIN_YES', 'Si');
define ('LBL_ADMIN_NO', 'No');
define ('LBL_ADMIN_FOLDERS','Carpetas:');
define ('LBL_ADMIN_CHANNELS','Temas:');
define ('LBL_ADMIN_OPML','OPML:');  
define ('LBL_ADMIN_ITEM','Temas:');
define ('LBL_ADMIN_CONFIG','Configuraci&oacute;n:');
define ('LBL_ADMIN_OK','Aceptar');
define ('LBL_ADMIN_CANCEL','Cancelar');
//FIXME:
define ('LBL_ADMIN_LOGOUT','Desconectar');

define ('LBL_ADMIN_OPML_IMPORT','Importar');
define ('LBL_ADMIN_OPML_EXPORT','Exportar');
define ('LBL_ADMIN_OPML_IMPORT_OPML','Importar OPML:');
define ('LBL_ADMIN_OPML_EXPORT_OPML','Exportar OPML:');
define ('LBL_ADMIN_OPML_IMPORT_FROM_URL','... desde URL:');
define ('LBL_ADMIN_OPML_IMPORT_FROM_FILE','... desde Archivo:');
define ('LBL_ADMIN_FILE_IMPORT','Importar archivo');


define ('LBL_ADMIN_IN_FOLDER','en la carpeta:');
define ('LBL_ADMIN_SUBMIT_CHANGES', 'Guardar cambios');
define ('LBL_ADMIN_PREVIEW_CHANGES','Previsualizar');
define ('LBL_ADMIN_CHANNELS_HEADING_TITLE','Titulo');
define ('LBL_ADMIN_CHANNELS_HEADING_FOLDER','Carpeta');
define ('LBL_ADMIN_CHANNELS_HEADING_DESCR','Descripcion');
define ('LBL_ADMIN_CHANNELS_HEADING_MOVE','Mover');
define ('LBL_ADMIN_CHANNELS_HEADING_ACTION','Accion');
define ('LBL_ADMIN_CHANNELS_HEADING_FLAGS','Destacado');
define ('LBL_ADMIN_CHANNELS_HEADING_KEY','Clave');
define ('LBL_ADMIN_CHANNELS_HEADING_VALUE','Value');
define ('LBL_ADMIN_CHANNELS_ADD','Nuevo canal:');
define ('LBL_ADMIN_FOLDERS_ADD','Nueva carpeta:');
define ('LBL_ADMIN_CHANNEL_ICON','Mostrar icono:');
define ('LBL_CLEAR_FOR_NONE','(Dejar en blanco para anular el icono)');

define ('LBL_ADMIN_CONFIG_VALUE','Valor para');

define ('LBL_ADMIN_PLUGINS_HEADING_NAME','Nombre');
define ('LBL_ADMIN_PLUGINS_HEADING_AUTHOR','Autor');
define ('LBL_ADMIN_PLUGINS_HEADING_VERSION','Version');
define ('LBL_ADMIN_PLUGINS_HEADING_DESCRIPTION','Descripcion');
define ('LBL_ADMIN_PLUGINS_HEADING_ACTION','Activo');




define ('LBL_ADMIN_CHANNEL_EDIT_CHANNEL','Editar canal ');
define ('LBL_ADMIN_CHANNEL_NAME','Titulo:');
define ('LBL_ADMIN_CHANNEL_RSS_URL','URL RSS:');
define ('LBL_ADMIN_CHANNEL_SITE_URL','URL Sitio:');
define ('LBL_ADMIN_CHANNEL_FOLDER','En carpeta:');
define ('LBL_ADMIN_CHANNEL_DESCR','Descripcion:');
define ('LBL_ADMIN_FOLDER_NAME','Nombre carpeta:');
define ('LBL_ADMIN_CHANNEL_PRIVATE','El canal es <strong>privado</strong>, solo lo ven los administradores');
define ('LBL_ADMIN_CHANNEL_DELETED','El tema <strong>no esta aprovado</strong>, no ser&aacute; puesto al d&iacute;a m&aacute;s y no ser&aacute; visible en la columna de las canales.');

define ('LBL_ADMIN_ARE_YOU_SURE', "Est&aacute; seguro de querer eliminar '%s'?");
define ('LBL_ADMIN_ARE_YOU_SURE_DEFAULT','Est&aacute; seguro que quiere establecer el valor de %s al predeterminado \'%s\'?');
define ('LBL_ADMIN_TRUE','Si');
define ('LBL_ADMIN_FALSE','No');
define ('LBL_ADMIN_MOVE_UP','&uarr;');
define ('LBL_ADMIN_MOVE_DOWN','&darr;');
define ('LBL_ADMIN_ADD_CHANNEL_EXPL','(Introduce la URL del canal RSS o web en la que te desees suscribir)');
define ('LBL_ADMIN_FEEDS','Los canales siguientes fueron encontrados dentro de <a href="%s">%s</a>, quieres suscribirte a alguno?');

define ('LBL_ADMIN_PRUNE_OLDER','Eliminar temas m&aacute;s viejos de ');
define ('LBL_ADMIN_PRUNE_DAYS','d&iacute;as');
define ('LBL_ADMIN_PRUNE_MONTHS','meses');
define ('LBL_ADMIN_PRUNE_YEARS','a 	&ntilde;os');
define ('LBL_ADMIN_PRUNE_KEEP','Proteger temas m&aacute;s recientes: ');
define ('LBL_ADMIN_PRUNE_INCLUDE_STICKY','Eliminar temas destacados: ');
define ('LBL_ADMIN_PRUNE_EXCLUDE_TAGS','No eliminar temas con tag... ');
define ('LBL_ADMIN_ALLTAGS_EXPL','(Ponga <strong>*</strong> para proteger todos los temas con tag)');

define ('LBL_ADMIN_ABOUT_TO_DELETE','Atenci&oacute;n: est&aacute; apunto de eliminar %s temas (de %s)');
define ('LBL_ADMIN_PRUNING','Limpieza');
define ('LBL_ADMIN_DOMAIN_FOLDER_LBL','carpetas');
define ('LBL_ADMIN_DOMAIN_CHANNEL_LBL','canales');
define ('LBL_ADMIN_DOMAIN_ITEM_LBL','temas');
define ('LBL_ADMIN_DOMAIN_CONFIG_LBL','config');
define ('LBL_ADMIN_DOMAIN_LBL_OPML_LBL','opml');
define ('LBL_ADMIN_BOOKMARKET_LABEL','Suscripcion bookmarklet [<a href="http://www.squarefree.com/bookmarklets/">?</a>]:');
define ('LBL_ADMIN_BOOKMARKLET_TITLE','Suscribir en Gregarius!');


define ('LBL_ADMIN_ERROR_NOT_AUTHORIZED', 
 		"<h1>No autorizado!</h1>\nNo est&aacute; autorizado para acceder al area de administraci&oacute;n.\n"
		."Por favor siga <a href=\"%s\">este enlace</a> para volver atras.\n"
		."Le deseamos un buen d&iacute;a!");
		
define ('LBL_ADMIN_ERROR_PRUNING_PERIOD','Periodo de limpieza no valido');
define ('LBL_ADMIN_ERROR_NO_PERIOD','Oops, no ha especificado un periodo');
define ('LBL_ADMIN_BAD_RSS_URL',"Lo siento, creo que no podemos hacer nada con esta URL: '%s'");
define ('LBL_ADMIN_ERROR_CANT_DELETE_HOME_FOLDER',"No puede eliminar la carpeta " . LBL_HOME_FOLDER);
define ('LBL_ADMIN_CANT_RENAME',"No puede renombrar esta carpeta '%s' porque la otra ya existe.");
define ('LBL_ADMIN_ERROR_CANT_CREATE',"Ahora tiene una carpeta llamada '%s'!");

define ('LBL_TAG_TAGS','Tags');
define ('LBL_TAG_EDIT','editar');
define ('LBL_TAG_SUBMIT','enviar');
define ('LBL_TAG_CANCEL','cancelar');
define ('LBL_TAG_SUBMITTING','...');
define ('LBL_TAG_ERROR_NO_TAG',"Oops! No existen temas con tag &laquo;%s&raquo;");
define ('LBL_TAG_ALL_TAGS','Todos los tags');
define ('LBL_TAG_TAGGED','tagged');
define ('LBL_TAG_TAGGEDP','tagged');
define ('LBL_TAG_SUGGESTIONS','sugerencias');
define ('LBL_TAG_SUGGESTIONS_NONE','sin sugerencias');
define ('LBL_TAG_RELATED','Tags relacionados: ');

define ('LBL_SHOW_UNREAD_ALL_SHOW','Mostrar temas: ');
define ('LBL_SHOW_UNREAD_ALL_UNREAD_ONLY','Sin leer');
define ('LBL_SHOW_UNREAD_ALL_READ_AND_UNREAD','Sin leer y leidos');

define ('LBL_STATE_UNREAD','Sin leer (Cambia el estado de lectura)');
define ('LBL_STATE_STICKY','Destacado (No ser&aacute;n eliminados por las tareas de limpieza)');
define ('LBL_STATE_PRIVATE','Privado (Solo los administradores pueden ver estos temas)');
define ('LBL_STICKY','Destacado');
define ('LBL_DEPRECATED','No aprovado');
define ('LBL_PRIVATE','Privado');
define ('LBL_ADMIN_STATE','Estado:');
define ('LBL_ADMIN_STATE_SET','Cambia');
define ('LBL_ADMIN_IM_SURE','Estoy seguro!');

// new in 0.5.1:
define ('LBL_LOGGED_IN_AS','Conectado como <strong>%s</strong>');
define ('LBL_NOT_LOGGED_IN','No conectado');
define ('LBL_LOG_OUT','Desconectar');
define ('LBL_LOG_IN','Conectar');

define ('LBL_ADMIN_OPML_IMPORT_AND','Importar nuevos canales y:');
define ('LBL_ADMIN_OPML_IMPORT_WIPE','... remplazar existentes.');
define ('LBL_ADMIN_OPML_IMPORT_FOLDER','... incluirlos a la carpeta:');
define ('LBL_ADMIN_OPML_IMPORT_MERGE','... unir con los existentes.');

define ('LBL_ADMIN_OPML_IMPORT_FEED_INFO','Importando %s a %s... ');

define ('LBL_TAG_FOLDERS','Categorias');
define ('LBL_SIDE_ITEMS','(%d temas)');
define ('LBL_SIDE_UNREAD_FEEDS','(%d sin leer en %d feeds)');
define ('LBL_CATCNT_PF', '<strong>%d</strong> canales en <strong>%d</strong> carpetas');

define ('LBL_RATING','Valoraci&oacute;n:');

// New in 0.5.3:
define('LBL_ENCLOSURE', 'Recipiente:');
define('LBL_DOWNLOAD', 'descargar');
define('LBL_PLAY', 'reproducir');
define('LBL_FOOTER_LAST_MODIF_NEVER', 'Never');
define ('LBL_ADMIN_DASHBOARD','Dashboard');


define ('LBL_ADMIN_MUST_SET_PASS','<p>No Administrator has been specified yet!</p>'
		.'<p>Please provide an Administrator username and password now!</p>');
define ('LBL_USERNAME','Username');		
define ('LBL_PASSWORD','Password');
define ('LBL_PASSWORD2','Password (again)');
define ('LBL_ADMIN_LOGIN','Please log in');
define ('LBL_ADMIN_PASS_NO_MATCH','Passwords do not match!');

define ('LBL_ADMIN_PLUGINS','Plugins');
define ('LBL_ADMIN_DOMAIN_PLUGINS_LBL','plugins');
define ('LBL_ADMIN_PLUGINS_HEADING_OPTIONS','Options');
define ('LBL_ADMIN_PLUGINS_OPTIONS','Plugin Options');
define ('LBL_ADMIN_CHECK_FOR_UPDATES','Check for Updates');
define ('LBL_ADMIN_LOGIN_BAD_LOGIN','<strong>Oops!</strong> Bad login/password');
define ('LBL_ADMIN_LOGIN_NO_ADMIN','<strong>Oops!</strong> You are successfully '
			.'logged in as %s, but you don\\\'t have administration privileges. Log in again '
			.'with administration privileges or follow your way <a href="..">home</a>');


define ('LBL_ADMIN_PLUGINS_GET_MORE', '<p style="font-size:small">'
.'Plugins are third-party scripts that offer extended functionalities. '
.'More plugins can be downloaded at the <a style="text-decoration:underline" '
.' href="http://plugins.gregarius.net/">Plugin Repository</a>.</p>');

define ('LBL_LAST_UPDATE','Last update');						
define ('LBL_ADMIN_DOMAIN_THEMES_LBL','themes');
define ('LBL_ADMIN_THEMES','Themes');
define('LBL_ADMIN_ACTIVE_THEME','Active Theme');
define('LBL_ADMIN_USE_THIS_THEME','Use this Theme');
define('LBL_ADMIN_CONFIGURE','Configure');
define('LBL_ADMIN_THEME_OPTIONS','Theme Options');

define ('LBL_ADMIN_THEMES_GET_MORE', '<p style="font-size:small">'
.'Themes are made of a set of template files which specify how your Gregarius installation looks.<br />'
.'More themes can be downloaded at the <a style="text-decoration:underline" '
.' href="http://themes.gregarius.net/">Themes Repository</a>.</p>');

define ('LBL_STATE_FLAG','Flag (Flags an item for later reading)');
define ('LBL_FLAG','Flagged');

define ('LBL_MARK_READ', "Marcar todos como leidos");
define ('LBL_MARK_CHANNEL_READ', "Marcar este como leido");
define ('LBL_MARK_FOLDER_READ',"Marcar esta carpeta como leida");

define ('LBL_MARK_CHANNEL_READ_ALL', "Mark This Feed as Read");
define ('LBL_MARK_FOLDER_READ_ALL',"Mark This Folder as Read");
define ('LBL_MARK_CATEGORY_READ_ALL',"Mark This Category as Read");
?>
