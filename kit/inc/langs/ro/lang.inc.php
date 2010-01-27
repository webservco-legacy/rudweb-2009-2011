<?php
/**
 * $Id$
 *
 * $URL$
 * <BR>No description
 *
 * @author     Radu Maier <radu@rudisoft.net>
 * @copyright  Copyright (c) 2009, Radu Maier
 * @license    http://opensource.org/licenses/gpl-3.0.html
 * @version    $Revision$
 * @access     public
 * @package    RudWEb-1.0
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
./inc/langs/ro/lang.inc.php
14:28 2008-08-06
*/
if(!defined('_RUDWEB_PUBFIL')) {require_once './../../lib/404.php';}

// WINDOW STATUS
$rudweb_ln['WinStatDef']      = _RUDWEB_WSTT;
$rudweb_ln['WinStatOver']     = _RUDWEB_WSTT;
$rudweb_ln['WinStatOut']      = _RUDWEB_WSTT;

// VISITORS STATISTICS
$rudweb_ln['total_visitors']  = "total vizitatori";
$rudweb_ln['visitors']        = "vizitatori";
$rudweb_ln['unique_visitors'] = "vizitatori unici";
$rudweb_ln['online_visitors'] = "vizitator(i) online";
$rudweb_ln['since']           = "de la";

//LOGIN STATUS & MESSAGES
$rudweb_ln['lgnst'][1] = "Ne&#238;nregistrat";
$rudweb_ln['lgnst'][2] = "C&#226;mpuri incomplete";
$rudweb_ln['lgnst'][3] = "Date incorecte";
$rudweb_ln['lgnst'][4] = "Cont suspendat";
$rudweb_ln['lgnst'][5] = "Autentificare reu&#351;it&#259;";
$rudweb_ln['lgnst'][6] = "Autentificat";
$rudweb_ln['lgnst'][7] = "Cod de securitate incorect";

$rudweb_ln['level']    = "Nivel de acces: ";
$rudweb_ln['logout']   = "Ie&#351;ire";

// COPYRIGHT
$rudweb_ln['cpy']['1'] = "Copyright";
$rudweb_ln['cpy']['2'] = "Toate drepturile rezervate";
$rudweb_ln['cpy']['3'] = "Web presence by";

// COMMENTS
$rudweb_ln['cmnts']['comments'] = "opinii";

// BLOG RELATED
$rudweb_ln['blg']['postedby'] = "Ad&#259;ugat de ";
$rudweb_ln['blg']['on']       = " la ";
$rudweb_ln['blg']['lastmod']  = "Modificat de ";

// ADMIN FORMS
$rudweb_ln['adm']['mnu_tt']       = "Titlu Meniu:";
$rudweb_ln['adm']['mnu_trg']      = "Target:";
$rudweb_ln['adm']['pic0']         = "Poze [0]:";
$rudweb_ln['adm']['pic1']         = "Poze [1]:";
$rudweb_ln['adm']['pic2']         = "Poze [2]:";
$rudweb_ln['adm']['pic3']         = "Poze [3]:";
$rudweb_ln['adm']['pic4']         = "Poze [4]:";
$rudweb_ln['adm']['nopic']        = "FARA POZA"; // NO SPECIAL CHARS HERE!
$rudweb_ln['adm']['new_pic']      = "Poz&#259; nou&#259;:";
$rudweb_ln['adm']['pic_tmb']      = "thumbnail";
$rudweb_ln['adm']['new_content']  = "ADAUG&#258; CON&#354;INUT";
$rudweb_ln['adm']['new_link']     = "ADAUG&#258; LEG&#258;TUR&#258;";
$rudweb_ln['adm']['new_page']     = "ADAUG&#258; PAGIN&#258;";
$rudweb_ln['adm']['cnt_tt']       = "Titlu Con&#355;inut:";
$rudweb_ln['adm']['cnt_stt']      = "Subtitlu con&#355;inut:";
$rudweb_ln['adm']['cnt_kw']       = "Cuvinte cheie:";
$rudweb_ln['adm']['cnt_dsc']      = "Descriere:";
$rudweb_ln['adm']['cnt_txt']      = "Text:";
$rudweb_ln['adm']['cnt_mod']      = "Modific&#259; Con&#355;inut";
$rudweb_ln['adm']['cnt_del']      = "&#350;terge Con&#355;inut";
$rudweb_ln['adm']['cnt_add']      = "Adaug&#259; Con&#355;inut";
$rudweb_ln['adm']['lnk_tt']       = "Titlu Leg&#259;tur&#259;:";
$rudweb_ln['adm']['lnk_url']      = "URL Leg&#259;tur&#259;:";
$rudweb_ln['adm']['lnk_trg']      = "Target Leg&#259;tur&#259;:";
$rudweb_ln['adm']['lnk_dsc']      = "Descriere Leg&#259;tur&#259;:";
$rudweb_ln['adm']['cnt_add_lnk']  = "Adaug&#259; Leg&#259;tur&#259;";
$rudweb_ln['adm']['pg_name']      = "Nume Pagin&#259;:";
$rudweb_ln['adm']['cnt_add_pg']   = "Adaug&#259; Pagin&#259;";
$rudweb_ln['adm']['pic_del']      = "&#350;terge Poza:";
$rudweb_ln['adm']['pic_repl']     = "&#206;nlocuie&#351;te Poza:";
$rudweb_ln['adm']['ftr_sup']      = "Descriere:";
$rudweb_ln['adm']['ftr_valid']    = "Validitate:";
$rudweb_ln['adm']['cal_months']   = "'Ianuarie','Februarie','Martie','Aprilie','Mai','Iunie','Iulie','August','Septembrie','Octombrie','Noiembrie','Decembrie'";
$rudweb_ln['adm']['cal_days']     = "'D','L','M','M','J','V','S'";
$rudweb_ln['adm']['cal_today']    = "Ast&#259;zi";

//$rudweb_ln['adm']['ftrmodstat0']  = "Modulul de oferte este inactiv.";
//$rudweb_ln['adm']['ftrmodstat00'] = "Modifica&#355;i fi&#351;ierul de configurare pentru a-l activa.";
//$rudweb_ln['adm']['ftrmodstat01'] = "Activare.";

//$rudweb_ln['adm']['ftrmodstat1']  = "Modulul de oferte este activ.";
//$rudweb_ln['adm']['ftrmodstat11'] = "Modifica&#355;i fi&#351;ierul de configurare pentru a-l dezactiva.";
//$rudweb_ln['adm']['ftrmodstat12'] = "Modifica&#355;i fi&#351;ierul de configurare pentru a schimba.";
//$rudweb_ln['adm']['ftrmodstat10'] = "Dezactivare.";

//$rudweb_ln['adm']['ftrlmttxt1']   = "Num&#259;r de oferte afi&#351;ate: ";
//$rudweb_ln['adm']['ftrdel']       = "&#350;terge pe aceasta: ";


//$rudweb_ln['adm']['ftrlmt']       = "Salveaz&#259;";
//$rudweb_ln['adm']['ftrmod']       = "Salveaz&#259; Modific&#259;ri";
//$rudweb_ln['adm']['ftrnew']       = "Adaug&#259; Nou";

//USER MODULE
$rudweb_ln['usr']['alreadyreg']    = 'Utilizator &#238;nregistrat';
$rudweb_ln['usr']['retuser']       = "Utilizator existent";
$rudweb_ln['usr']['newuser']       = "Utilizator nou";
$rudweb_ln['usr']['signup']        = "&#206;nscriere";

$rudweb_ln['usr']['newuserreg']    = "Inregistrare utilizator nou";
$rudweb_ln['usr']['usrfirstname']  = "Prenume";
$rudweb_ln['usr']['usrmiddlename'] = "Initiale";
$rudweb_ln['usr']['usrlastname']   = "Nume";
$rudweb_ln['usr']['usrphone']      = "Nr. Telefon";
$rudweb_ln['usr']['usraddress']    = "Adresa";
$rudweb_ln['usr']['usrcountry']    = "Tara";
$rudweb_ln['usr']['usremail1']     = "Adresa e-mail";
$rudweb_ln['usr']['usremail2']     = "Adresa e-mail din nou";
$rudweb_ln['usr']['usrpass1']      = "Parola aleas&#259;";
$rudweb_ln['usr']['usrpass2']      = "Parola aleas&#259; din nou";
$rudweb_ln['usr']['usrprefln']     = "Limba preferat&#259;";
$rudweb_ln['usr']['usrsubscribe1'] = "Abonare";
$rudweb_ln['usr']['usrsubscribe2'] = "Doresc sa ma abonez";
$rudweb_ln['usr']['usragree1']     = "De acord";
$rudweb_ln['usr']['usragree2']     = "Sunt de acord cu";
$rudweb_ln['usr']['usragree3']     = "termenii si conditiile";
$rudweb_ln['usr']['usragree4']     = "website-ului";
$rudweb_ln['usr']['usrverif']      = "Verificare";
$rudweb_ln['usr']['regerr1']       = "Campul cu prenumele este gol!";
$rudweb_ln['usr']['regerr2']       = "Campul cu numele este gol!";
$rudweb_ln['usr']['regerr3']       = "Campul cu tara este gol!";
$rudweb_ln['usr']['regerr4']       = "Campul cu adresa de e-mail este gol!";
$rudweb_ln['usr']['regerr5']       = "Adresa de email nu este valida!";
$rudweb_ln['usr']['regerr6']       = "Adresele de email nu corespund!";
$rudweb_ln['usr']['regerr7']       = "Campul cu parola este gol!";
$rudweb_ln['usr']['regerr8']       = "Parola este prea scurta!";
$rudweb_ln['usr']['regerr9']       = "Parolele nu corespund!";
$rudweb_ln['usr']['regerr10']      = "Trebuie sa fiti de acord cu termenii!";
$rudweb_ln['usr']['regerr11']      = "Verificarea de imagine a esuat!";
$rudweb_ln['usr']['regerr12']      = "Adresa de email exista deja in baza noastra de date!";
$rudweb_ln['usr']['regerr13']      = "Ati aplicat deja pentru un cont! Verificati email-ul pentru instructiuni de activare";
$rudweb_ln['usr']['regerr14']      = "Ati aplicat deja pentru un cont dar nu am reusit sa trimitem email-ul de activare!";

$rudweb_ln['usr']['accact']        = "Activarea unui cont nou";
$rudweb_ln['usr']['aaerror1']      = "Cod de autorizare invalid.";
$rudweb_ln['usr']['aaerror2']      = "Probabil contul este deja activ?";

$rudweb_ln['usr']['lostpass']      = "Pierdut Parola?";
$rudweb_ln['usr']['lostpsubmit']   = "Urm&#259;torul";
$rudweb_ln['usr']['lpaerror1']     = "Cod de autorizare invalid.";
$rudweb_ln['usr']['lpaerror2']     = "Probabil a expirat?";

// CATALOG
$rudweb_ln['cat']['noitems']       = 'Nu sunt produse';
$rudweb_ln['cat']['quantity']      = 'Cantitate';
$rudweb_ln['cat']['itemaddok']     = 'Produsul a fost ad&#259;ugat cu succes!';
$rudweb_ln['cat']['itemmodok']     = 'Produsul a fost modificat cu succes!';
$rudweb_ln['cat']['itemdelok']     = 'Produsul a fost &#351;ters cu succes!';
$rudweb_ln['cat']['itemaddnew']    = 'Ad&#259;ugare produs nou';
$rudweb_ln['cat']['itemmod']       = 'Modificare produs';
$rudweb_ln['cat']['itemviewcat']   = 'Vizualizare produse din categoria curenta';
$rudweb_ln['cat']['ipg']           = 'Articole / pagin&#259;';
$rudweb_ln['cat']['pcs']           = 'Formulare de upload poze';

// PAGINATION
$rudweb_ln['pgnav']['first']       = '&#60;&#60;';
$rudweb_ln['pgnav']['prev']        = '&#60;';
$rudweb_ln['pgnav']['next']        = '&#62;';
$rudweb_ln['pgnav']['last']        = '&#62;&#62;';
$rudweb_ln['pgnav']['page']        = 'pagina ';
$rudweb_ln['pgnav']['of']          = ' din ';

//ADMINISTRATION
$rudweb_ln['adm']['adm']           = 'Administrare';
$rudweb_ln['adm']['add']           = 'Ad&#259;ugare';
$rudweb_ln['adm']['mov']           = 'Mutare';
$rudweb_ln['adm']['mod']           = 'Modificare';
$rudweb_ln['adm']['del']           = '&#350;tergere';
$rudweb_ln['adm']['sel']           = 'Selecta&#355;i';
$rudweb_ln['adm']['chl']           = 'caractere r&#259;mase';
$rudweb_ln['adm']['viewrights']    = 'Nivel drepturi vizualizare';
$rudweb_ln['adm']['level']         = 'Level';
$rudweb_ln['adm']['lvl'][0]        = 'Vizitatori';
$rudweb_ln['adm']['lvl'][1]        = 'Utilizatori';
$rudweb_ln['adm']['lvl'][2]        = 'Utilizatori VIP';
$rudweb_ln['adm']['lvl'][3]        = 'Administratori';
$rudweb_ln['adm']['lvl'][4]        = 'Proprietar';
$rudweb_ln['adm']['lvl'][5]        = 'Root';
$rudweb_ln['adm']['tt']            = 'Titlu';
$rudweb_ln['adm']['stt']           = 'Subtitlu';
$rudweb_ln['adm']['dsc']           = 'Descriere';
$rudweb_ln['adm']['txt']           = 'Con&#355;inut';
$rudweb_ln['adm']['noitems']       = 'Nu sunt articole';
$rudweb_ln['adm']['itemaddok']     = 'Articolul a fost ad&#259;ugat cu succes!';
$rudweb_ln['adm']['itemmodok']     = 'Articolul a fost modificat cu succes!';
$rudweb_ln['adm']['itemdelok']     = 'Articolul a fost &#351;ters cu succes!';
$rudweb_ln['adm']['itemaddnew']    = 'Ad&#259;ugare articol nou';
$rudweb_ln['adm']['itemmod']       = 'Modificare articol';
$rudweb_ln['adm']['itemviewcat']   = 'Vizualizare articole din categoria curent&#259;';
$rudweb_ln['adm']['settings']      = 'Set&#259;ri';
$rudweb_ln['adm']['save']          = 'Salveaz&#259;';
$rudweb_ln['adm']['savemod']       = 'Salveaz&#259; modific&#259;ri';
$rudweb_ln['adm']['filter']        = 'Filtrare';
$rudweb_ln['adm']['reset']         = 'Resetare';

// CATALOG SPECIAL OFFERS
$rudweb_ln['adm']['cspmodstat0']  = "Modulul de oferte speciale este inactiv.";
$rudweb_ln['adm']['cspmodstat00'] = "Modifica&#355;i fi&#351;ierul de configurare pentru a-l activa.";
$rudweb_ln['adm']['cspmodstat01'] = "Activare.";
$rudweb_ln['adm']['cspmodstat1']  = "Modulul de oferte speciale este activ.";
$rudweb_ln['adm']['cspmodstat11'] = "Modifica&#355;i fi&#351;ierul de configurare pentru a-l dezactiva.";
$rudweb_ln['adm']['cspmodstat12'] = "Modifica&#355;i fi&#351;ierul de configurare pentru a schimba.";
$rudweb_ln['adm']['cspmodstat10'] = "Dezactivare.";
$rudweb_ln['adm']['csplmttxt1']   = "Num&#259;r de articole afi&#351;ate: ";
$rudweb_ln['csp']['delone']       = "&#350;terge pe aceasta: ";
//$rudweb_ln['adm']['csplmt']       = "Salveaz&#259;";

// CONTENT
$rudweb_ln['cnt']['cnt']          = "Con&#355;inut";
// TAGS
$rudweb_ln['cnt']['tags']         = "Tag-uri";
$rudweb_ln['cnt']['avltags']      = "Tag-uri disponibile: ";
$rudweb_ln['adm']['tagmodstat0']  = "Modulul de tag-uri este inactiv.";
$rudweb_ln['adm']['tagmodstat00'] = "Modifica&#355;i fi&#351;ierul de configurare pentru a-l activa.";
$rudweb_ln['adm']['tagmodstat01'] = "Activare.";
$rudweb_ln['adm']['tagmodstat1']  = "Modulul de tag-uri este activ.";
$rudweb_ln['adm']['tagmodstat11'] = "Modifica&#355;i fi&#351;ierul de configurare pentru a-l dezactiva.";
$rudweb_ln['adm']['tagmodstat10'] = "Dezactivare.";
$rudweb_ln['csp']['deltags']      = "&#350;terge tag-urile selectate";
$rudweb_ln['csp']['delutags']     = "&#350;terge toate tag-urile nefolosite";

// COMMENTS
$rudweb_ln['cmt']['cmtt']         = "Opinii";
$rudweb_ln['cmt']['cmt']          = "opinii";
$rudweb_ln['cmt']['cmtal']        = "Adaug&#259; opinie";
$rudweb_ln['cmt']['cmtvl']        = "Vizualizare opinii";

// MODULE ADMINISTARTION
$rudweb_ln['adm']['modules']   = "Module";
$rudweb_ln['adm']['modstat0']  = "Modulul este inactiv.";
$rudweb_ln['adm']['modstat00'] = "Modifica&#355;i fi&#351;ierul de configurare pentru a-l activa.";
$rudweb_ln['adm']['modstat01'] = "Activare.";
$rudweb_ln['adm']['modstat1']  = "Modulul este activ.";
$rudweb_ln['adm']['modstat11'] = "Modifica&#355;i fi&#351;ierul de configurare pentru a-l dezactiva.";
$rudweb_ln['adm']['modstat12'] = "Modifica&#355;i fi&#351;ierul de configurare pentru a schimba.";
$rudweb_ln['adm']['modstat10'] = "Dezactivare.";
$rudweb_ln['adm']['lmttxt1']   = "Num&#259;r de articole de afi&#351;at";
$rudweb_ln['adm']['new']       = "Ad&#259;ugare";

// NEWS
$rudweb_ln['nws']['tt']  = "&#350;tiri";
$rudweb_ln['nws']['allnews'] = "Toate &#351;tirile";
$rudweb_ln['nws']['ltstnews'] = "Ultimele &#351;tiri";

// ERROR MESSAGES
$rudweb_ln['err']['tt']           = 'OOPS!';
$rudweb_ln['err']['0']            = "Oops! Pagina nu a fost gasit&#259;!";
$rudweb_ln['err']['1']            = "Ne pare r&#259;u! Nu ave&#355;i permisiune s&#259; accesa&#355;i aceast&#259; pagin&#259;!";
$rudweb_ln['err']['3']            = "Ne pare r&#259;u! Cererea nu este valid&#259;!";
$rudweb_ln['err']['itemadd']['1'] = 'C&#226;mpul ' .$rudweb_ln['prod']['pname'] . ' este gol!';
$rudweb_ln['err']['itemadd']['2'] = 'V&#259; rug&#259;m selecta&#355;i o valoare din list&#259;!';
$rudweb_ln['err']['itemadd']['3'] = 'V&#259; rug&#259;m completa&#355;i c&#226;mpurile obligatorii!';
$rudweb_ln['err']['add']['1']     = 'C&#226;mpul ' .$rudweb_ln['adm']['tt'] . ' este gol!';
$rudweb_ln['err']['add']['2']     = 'C&#226;mpul ' .$rudweb_ln['adm']['stt'] . ' este gol!';
$rudweb_ln['err']['add']['3']     = 'C&#226;mpul ' .$rudweb_ln['adm']['dsc'] . ' este gol!';
$rudweb_ln['err']['add']['4']     = 'C&#226;mpul ' .$rudweb_ln['adm']['txt'] . ' este gol!';

// MSIC STUFF
$rudweb_ln['about']  = "Despre";
$rudweb_ln['name']   = "Denumire";
$rudweb_ln['yes']    = "Da";
$rudweb_ln['no']     = "Nu";
$rudweb_ln['categs'] = "Categorii";
$rudweb_ln['dets']   = "Detalii";
$rudweb_ln['opts']   = "Op&#355;iuni";
$rudweb_ln['type']   = "Tip";
$rudweb_ln['order']  = "Ordine";
$rudweb_ln['req']    = "Obligatoriu";
$rudweb_ln['main']   = "Principal";
$rudweb_ln['text']   = "Text";
$rudweb_ln['select'] = "Selec&#355;ie";
$rudweb_ln['send']   = "Trimite";
$rudweb_ln['reset']  = "Reseteaz&#259;";
$rudweb_ln['new']    = "Nou";
$rudweb_ln['new2']   = "Noi";
$rudweb_ln['number'] = "Nr";
$rudweb_ln['date']   = "Data";
$rudweb_ln['time']   = "Ora";
$rudweb_ln['email']  = "Email";
$rudweb_ln['read']   = "Citit";
$rudweb_ln['solved'] = "Rezolvat";

// CONTACT
$rudweb_ln['con']['tt']      = "Contact";
$rudweb_ln['con']['not3']    = "Notificare Nivel 3";
$rudweb_ln['con']['not4']    = "Notificare Nivel 4";
$rudweb_ln['con']['notE']    = "Notificare email";
$rudweb_ln['con']['sendE']   = "Trimitere email";
$rudweb_ln['con']['name']    = "Nume";
$rudweb_ln['con']['email']   = "Email";
$rudweb_ln['con']['msg']     = "Mesaj";
$rudweb_ln['con']['msgs']    = "Mesaje";
$rudweb_ln['con']['amsg']    = "Toate Mesajele";
$rudweb_ln['con']['frby']    = "Citit prima data de ";
$rudweb_ln['con']['sby']     = "Rezolvat de ";
$rudweb_ln['con']['sets']    = "Setare Rezolvat";
$rudweb_ln['con']['general'] = "General";

// PRINT
$rudweb_ln['print']['page'] = "Imprim&#259; aceast&#259; pagin&#259;";
?>