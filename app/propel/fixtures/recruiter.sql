-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 16, 2012 at 09:53 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Dumping data for table `visual_role`
--

INSERT INTO `visual_role` (`id`, `name`, `description`, `type`, `is_active`) VALUES
(1, 'ROLE_ADMIN_GODMODE', 'pełne prawo do administracji systemem',0, 1),
(2, 'ROLE_ADMIN', 'prawo do administracji', 0, 1),
(3, 'ROLE_USER_FRONTEND', 'prawo do manipulacji na frontend', 1, 1),
(4, 'ROLE_USER_GROUP', 'prawo dla użytkownika grupy', 1, 1),
(5, 'ROLE_USER_ADMINGROUP', 'prawo administracji grupą', 0, 1);

--
-- Dumping data for table `visual_user`
--

INSERT INTO `visual_user` (`id`, `name`, `surname`, `username`, `password`, `email`, `salt`, `barcode`, `type`, `street`, `flat`, `city`, `postcode`, `is_superadmin`, `is_active`, `is_agree_processing`, `is_agree_regulations`, `created_at`, `updated_at`) VALUES
(1, 'System', 'Admin', 'admin', 'SKNPnl1QL1VzDHt/Iub76OVxh/E=', NULL, 'c23819553d84efacaf51794ed633d7da', NULL, 'individual', NULL, NULL, NULL, NULL, 1, 1, 0, 0, '2012-03-16 09:52:22', '2012-03-16 09:52:22');

--
-- Dumping data for table `visual_user_role`
--

INSERT INTO `visual_user_role` (`user_id`, `role_id`) VALUES
(1, 1), (1, 2);

INSERT INTO `visual_group` (`id` ,`name` ,`street` ,`flat` ,`city` ,`postcode` ,`nip` ,`created_at` ,`updated_at`)VALUES 
(1 , 'admin', NULL , NULL , NULL , NULL , NULL , NULL , NULL);

INSERT INTO `visual_user_group` (`user_id` ,`group_id` ,`is_group_admin`)VALUES 
(1, 1, 1);

INSERT INTO `visual_menu` (`id`, `is_active`, `url`, `created_at`, `updated_at`, `sortable_rank`) VALUES
(2, 1, NULL, '2012-05-30 23:59:53', '2012-05-30 23:59:53', 1),
(3, 1, NULL, '2012-06-05 16:09:40', '2012-06-05 16:09:40', 2);

INSERT INTO `visual_menu_i18n` (`id`, `locale`, `name`, `slug`, `content`, `created_at`, `updated_at`) VALUES
(2, 'de_DE', NULL, 'n-a', NULL, '2012-05-30 23:59:53', '2012-05-30 23:59:53'),
(2, 'en_EN', NULL, 'n-a', NULL, '2012-05-30 23:59:53', '2012-05-30 23:59:53'),
(2, 'pl_PL', 'Polityka prywatności', 'polityka-prywatnoci', '<div class="static-content">\r\n	Korzystając z aplikacji akceptujesz warunki zawarte w polityce prywatności.</div>\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<div class="bar">\r\n					<span>Dane uczestnika</span></div>\r\n			</td>\r\n			<td>\r\n				<div class="bar">\r\n					<span>Poczta elektroniczna</span></div>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				<div class="static-content">\r\n					Dodając dane do bazy danych, tym samym zgadzasz się na exportowanie ich w celu kwalifikacji na dane wydarzenie. Hasło oraz mail zostają ukryte.</div>\r\n			</td>\r\n			<td>\r\n				<div class="static-content">\r\n					zglaszam.pl zastrzega sobie prawo do wysyłania niezapowiedzianych wiadomości pod adresy e-mail zarejestrowanych użytkownik&oacute;w. Wiadomości mogą dotyczyć np. zmian w serwisie. Adresy e-mail nie będą udostępniane.</div>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				<div class="bar">\r\n					<span>Cookies</span></div>\r\n			</td>\r\n			<td>\r\n				<div class="bar">\r\n					<span>Wyłączenie odpowiedzialności</span></div>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				<div class="static-content">\r\n					Cookies to małe pliki tekstowe wysyłane do komputera osoby, kt&oacute;ra właśnie znajduje się na stronie zglaszam.pl. Pliki te nie są w żaden spos&oacute;b szkodliwe dla Twojego komputera, wspomagają jedynie funkcjonowanie portalu.</div>\r\n			</td>\r\n			<td>\r\n				<div class="static-content">\r\n					zglaszam.pl nie ponosi odpowiedzialności za wiarygodność treści zamieszczanych przez rejestrujących się uczestnik&oacute;w.</div>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				<div class="bar">\r\n					<span>Postanowienie końcowe</span></div>\r\n			</td>\r\n			<td>\r\n				&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				<div class="static-content">\r\n					zglaszam.pl zastrzega sobie prawo do zmiany zapisu polityki prywatności. Nowy zapis obowiązuje od momentu opublikowania jej na stronie portalu.</div>\r\n			</td>\r\n			<td>\r\n				&nbsp;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n<p>\r\n	&nbsp;</p>', '2012-05-30 23:59:53', '2012-05-31 00:00:37'),
(3, 'de_DE', NULL, 'n-a', NULL, '2012-06-05 16:09:40', '2012-06-05 16:09:40'),
(3, 'en_EN', NULL, 'n-a', NULL, '2012-06-05 16:09:40', '2012-06-05 16:09:40'),
(3, 'pl_PL', 'Regulamin', 'regulamin', '<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<div class="bar">\r\n					<span>Postanowienia og&oacute;lne</span></div>\r\n			</td>\r\n			<td>\r\n				<div class="bar">\r\n					<div class="bar">\r\n						<span>Użytkownik</span></div>\r\n				</div>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				<div class="static-content">\r\n					Serwis zglaszam.pl służy do przeprowadzania rekrutacji na wybrane wydarzenie.<br />\r\n					<br />\r\n					Umożliwia tworzenie formularzy, pytań rekrutacyjnych. Każdy użytkownik systemu ma prawo do wykorzystywania narzędzia zgodnie z jego przeznaczeniem.</div>\r\n			</td>\r\n			<td>\r\n				<div class="static-content">\r\n					Rejestracja użytkownika przeprowadzana jest przez wypełnienie odpowiedniego formularza dostępnego w serwisie zglaszam.pl. Poprzez wysłanie formularza użytkownik potwierdza autentyczność danych wprowadzonych do formularza.<br />\r\n					<br />\r\n					Serwis zglaszam.pl umożliwia zarejestrowanym użytkownikom dodawanie oraz edycję informacji związanych z przeprowadzeniem rekrutacji.<br />\r\n					<br />\r\n					Serwis zglaszam.pl zastrzega sobie prawo do blokowania lub usuwania kont użytkownik&oacute;w bez podawania przyczyn.</div>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				<div class="bar">\r\n					<div class="bar">\r\n						<span>Odpowiedzialność</span></div>\r\n				</div>\r\n			</td>\r\n			<td>\r\n				&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				<div class="static-content">\r\n					Serwis zglaszam.pl nie ponosi odpowiedzialności za:<br />\r\n					<br />\r\n					jakiekolwiek szkody użytkownika spowodowane działaniem serwisu<br />\r\n					<br />\r\n					przypadki losowe i wadliwe działanie skrypt&oacute;w, kodu źr&oacute;dłowego; w szczeg&oacute;lności nie ponosi odpowiedzialności za serwery zewnętrzne<br />\r\n					<br />\r\n					skutki wejścia w posiadanie przez osoby trzecie loginu i hasła użytkownika<br />\r\n					<br />\r\n					przerwy w funkcjonowaniu systemu zaistniałe z przyczyn technicznych (konserwacja, przegląd, wymiana sprzętu) lub niezależnych od dostawcy<br />\r\n					<br />\r\n					utratę danych spowodowaną awarią sprzętu, systemu lub też innymi okolicznościami niezależnymi od dostawcy usługi</div>\r\n			</td>\r\n			<td>\r\n				&nbsp;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n<p>\r\n	&nbsp;</p>', '2012-06-05 16:09:40', '2012-06-05 16:18:28');

