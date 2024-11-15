-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Creato il: Ago 06, 2022 alle 23:42
-- Versione del server: 5.7.34
-- Versione PHP: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sito`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `description` text NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `category`
--

INSERT INTO `category` (`id`, `name`, `parent`, `status`, `description`, `date`) VALUES
(1, 'senza categoria', -1, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ipsum magna, tempus nec orci at, facilisis scelerisque mauris. Morbi non eros nec tellus interdum consequat nec nec felis. In nulla leo, maximus cursus auctor sit amet, tincidunt a dolor. Suspendisse potenti. Nunc posuere lacus et nunc ornare tempus. In eu justo in mi fermentum ullamcorper eget a nibh. Cras vel augue vitae lacus pellentesque malesuada at ut erat.', '2022-08-03 23:33:54'),
(6, 'Categoria1', -1, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ipsum magna, tempus nec orci at, facilisis scelerisque mauris. Morbi non eros nec tellus interdum consequat nec nec felis. In nulla leo, maximus cursus auctor sit amet, tincidunt a dolor. Suspendisse potenti. Nunc posuere lacus et nunc ornare tempus. In eu justo in mi fermentum ullamcorper eget a nibh. Cras vel augue vitae lacus pellentesque malesuada at ut erat.', '2022-08-03 23:33:54'),
(7, 'Categoria2', -1, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ipsum magna, tempus nec orci at, facilisis scelerisque mauris. Morbi non eros nec tellus interdum consequat nec nec felis. In nulla leo, maximus cursus auctor sit amet, tincidunt a dolor. Suspendisse potenti. Nunc posuere lacus et nunc ornare tempus. In eu justo in mi fermentum ullamcorper eget a nibh. Cras vel augue vitae lacus pellentesque malesuada at ut erat.', '2022-08-03 23:33:54'),
(8, 'Categoria3', -1, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ipsum magna, tempus nec orci at, facilisis scelerisque mauris. Morbi non eros nec tellus interdum consequat nec nec felis. In nulla leo, maximus cursus auctor sit amet, tincidunt a dolor. Suspendisse potenti. Nunc posuere lacus et nunc ornare tempus. In eu justo in mi fermentum ullamcorper eget a nibh. Cras vel augue vitae lacus pellentesque malesuada at ut erat.', '2022-08-03 23:33:54'),
(9, 'Categoria4', -1, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ipsum magna, tempus nec orci at, facilisis scelerisque mauris. Morbi non eros nec tellus interdum consequat nec nec felis. In nulla leo, maximus cursus auctor sit amet, tincidunt a dolor. Suspendisse potenti. Nunc posuere lacus et nunc ornare tempus. In eu justo in mi fermentum ullamcorper eget a nibh. Cras vel augue vitae lacus pellentesque malesuada at ut erat.', '2022-08-03 23:33:54'),
(10, 'Categoria5', -1, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ipsum magna, tempus nec orci at, facilisis scelerisque mauris. Morbi non eros nec tellus interdum consequat nec nec felis. In nulla leo, maximus cursus auctor sit amet, tincidunt a dolor. Suspendisse potenti. Nunc posuere lacus et nunc ornare tempus. In eu justo in mi fermentum ullamcorper eget a nibh. Cras vel augue vitae lacus pellentesque malesuada at ut erat.', '2022-08-03 23:33:54'),
(11, 'Categoria1a', 6, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ipsum magna, tempus nec orci at, facilisis scelerisque mauris. Morbi non eros nec tellus interdum consequat nec nec felis. In nulla leo, maximus cursus auctor sit amet, tincidunt a dolor. Suspendisse potenti. Nunc posuere lacus et nunc ornare tempus. In eu justo in mi fermentum ullamcorper eget a nibh. Cras vel augue vitae lacus pellentesque malesuada at ut erat.', '2022-08-03 23:33:54'),
(12, 'Categoria2a', 7, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ipsum magna, tempus nec orci at, facilisis scelerisque mauris. Morbi non eros nec tellus interdum consequat nec nec felis. In nulla leo, maximus cursus auctor sit amet, tincidunt a dolor. Suspendisse potenti. Nunc posuere lacus et nunc ornare tempus. In eu justo in mi fermentum ullamcorper eget a nibh. Cras vel augue vitae lacus pellentesque malesuada at ut erat.', '2022-08-03 23:33:54'),
(13, 'Categoria3a', 8, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ipsum magna, tempus nec orci at, facilisis scelerisque mauris. Morbi non eros nec tellus interdum consequat nec nec felis. In nulla leo, maximus cursus auctor sit amet, tincidunt a dolor. Suspendisse potenti. Nunc posuere lacus et nunc ornare tempus. In eu justo in mi fermentum ullamcorper eget a nibh. Cras vel augue vitae lacus pellentesque malesuada at ut erat.', '2022-08-03 23:33:54'),
(14, 'Categoria4a', 9, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ipsum magna, tempus nec orci at, facilisis scelerisque mauris. Morbi non eros nec tellus interdum consequat nec nec felis. In nulla leo, maximus cursus auctor sit amet, tincidunt a dolor. Suspendisse potenti. Nunc posuere lacus et nunc ornare tempus. In eu justo in mi fermentum ullamcorper eget a nibh. Cras vel augue vitae lacus pellentesque malesuada at ut erat.', '2022-08-03 23:33:54'),
(15, 'Categoria5a', 10, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ipsum magna, tempus nec orci at, facilisis scelerisque mauris. Morbi non eros nec tellus interdum consequat nec nec felis. In nulla leo, maximus cursus auctor sit amet, tincidunt a dolor. Suspendisse potenti. Nunc posuere lacus et nunc ornare tempus. In eu justo in mi fermentum ullamcorper eget a nibh. Cras vel augue vitae lacus pellentesque malesuada at ut erat.', '2022-08-03 23:33:54'),
(16, 'Categoria6', -1, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ipsum magna, tempus nec orci at, facilisis scelerisque mauris. Morbi non eros nec tellus interdum consequat nec nec felis. In nulla leo, maximus cursus auctor sit amet, tincidunt a dolor. Suspendisse potenti. Nunc posuere lacus et nunc ornare tempus. In eu justo in mi fermentum ullamcorper eget a nibh. Cras vel augue vitae lacus pellentesque malesuada at ut erat.', '2022-08-03 23:33:54'),
(17, 'Categoria6a', 16, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ipsum magna, tempus nec orci at, facilisis scelerisque mauris. Morbi non eros nec tellus interdum consequat nec nec felis. In nulla leo, maximus cursus auctor sit amet, tincidunt a dolor. Suspendisse potenti. Nunc posuere lacus et nunc ornare tempus. In eu justo in mi fermentum ullamcorper eget a nibh. Cras vel augue vitae lacus pellentesque malesuada at ut erat.', '2022-08-03 23:33:54'),
(18, 'Categoria7', -1, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ipsum magna, tempus nec orci at, facilisis scelerisque mauris. Morbi non eros nec tellus interdum consequat nec nec felis. In nulla leo, maximus cursus auctor sit amet, tincidunt a dolor. Suspendisse potenti. Nunc posuere lacus et nunc ornare tempus. In eu justo in mi fermentum ullamcorper eget a nibh. Cras vel augue vitae lacus pellentesque malesuada at ut erat.', '2022-08-03 23:33:54'),
(19, 'Categoria7a', 18, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ipsum magna, tempus nec orci at, facilisis scelerisque mauris. Morbi non eros nec tellus interdum consequat nec nec felis. In nulla leo, maximus cursus auctor sit amet, tincidunt a dolor. Suspendisse potenti. Nunc posuere lacus et nunc ornare tempus. In eu justo in mi fermentum ullamcorper eget a nibh. Cras vel augue vitae lacus pellentesque malesuada at ut erat.', '2022-08-03 23:33:54'),
(20, 'Categoria1b', 6, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ipsum magna, tempus nec orci at, facilisis scelerisque mauris. Morbi non eros nec tellus interdum consequat nec nec felis. In nulla leo, maximus cursus auctor sit amet, tincidunt a dolor. Suspendisse potenti. Nunc posuere lacus et nunc ornare tempus. In eu justo in mi fermentum ullamcorper eget a nibh. Cras vel augue vitae lacus pellentesque malesuada at ut erat.', '2022-08-03 23:33:54'),
(21, 'Categoria2b', 7, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ipsum magna, tempus nec orci at, facilisis scelerisque mauris. Morbi non eros nec tellus interdum consequat nec nec felis. In nulla leo, maximus cursus auctor sit amet, tincidunt a dolor. Suspendisse potenti. Nunc posuere lacus et nunc ornare tempus. In eu justo in mi fermentum ullamcorper eget a nibh. Cras vel augue vitae lacus pellentesque malesuada at ut erat.', '2022-08-03 23:33:54'),
(22, 'Categoria3b', 8, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ipsum magna, tempus nec orci at, facilisis scelerisque mauris. Morbi non eros nec tellus interdum consequat nec nec felis. In nulla leo, maximus cursus auctor sit amet, tincidunt a dolor. Suspendisse potenti. Nunc posuere lacus et nunc ornare tempus. In eu justo in mi fermentum ullamcorper eget a nibh. Cras vel augue vitae lacus pellentesque malesuada at ut erat.', '2022-08-03 23:33:54'),
(23, 'Categoria4b', 9, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ipsum magna, tempus nec orci at, facilisis scelerisque mauris. Morbi non eros nec tellus interdum consequat nec nec felis. In nulla leo, maximus cursus auctor sit amet, tincidunt a dolor. Suspendisse potenti. Nunc posuere lacus et nunc ornare tempus. In eu justo in mi fermentum ullamcorper eget a nibh. Cras vel augue vitae lacus pellentesque malesuada at ut erat.', '2022-08-03 23:33:54'),
(24, 'Categoria5b', 10, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ipsum magna, tempus nec orci at, facilisis scelerisque mauris. Morbi non eros nec tellus interdum consequat nec nec felis. In nulla leo, maximus cursus auctor sit amet, tincidunt a dolor. Suspendisse potenti. Nunc posuere lacus et nunc ornare tempus. In eu justo in mi fermentum ullamcorper eget a nibh. Cras vel augue vitae lacus pellentesque malesuada at ut erat.', '2022-08-03 23:33:54'),
(25, 'Categoria6b', 16, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ipsum magna, tempus nec orci at, facilisis scelerisque mauris. Morbi non eros nec tellus interdum consequat nec nec felis. In nulla leo, maximus cursus auctor sit amet, tincidunt a dolor. Suspendisse potenti. Nunc posuere lacus et nunc ornare tempus. In eu justo in mi fermentum ullamcorper eget a nibh. Cras vel augue vitae lacus pellentesque malesuada at ut erat.', '2022-08-03 23:33:54'),
(26, 'Categoria7b', 18, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ipsum magna, tempus nec orci at, facilisis scelerisque mauris. Morbi non eros nec tellus interdum consequat nec nec felis. In nulla leo, maximus cursus auctor sit amet, tincidunt a dolor. Suspendisse potenti. Nunc posuere lacus et nunc ornare tempus. In eu justo in mi fermentum ullamcorper eget a nibh. Cras vel augue vitae lacus pellentesque malesuada at ut erat.', '2022-08-03 23:33:54');

-- --------------------------------------------------------

--
-- Struttura della tabella `newsletter`
--

CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `uni_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `newsletter`
--

INSERT INTO `newsletter` (`id`, `email`, `uni_code`) VALUES
(2, 'a@a.a', 'e753c351a5c353f22e750e205261e4e9'),
(5, 'b@b.b', '8a7d4ad2dff1007458d3bb28e5d42898'),
(6, 'c@c.c', '526942ebd13d526cb54db3db4585a03e'),
(7, 'a@b.c', 'ca4f8b7f6be12edf2a37d358b19d3d75'),
(8, 'd@e.f', '3e80a0fd1a1302e833a062bab17278e9'),
(9, 'g@h.i', '6c2e99fbad3fdf95af97e45b71cd8268'),
(10, 'a@z.a', '87865b667ac43e669b52a25dd11ca5d4'),
(11, 'g@g.g', '9f9d47cb8e50c5958cac25882f4a1015');

-- --------------------------------------------------------

--
-- Struttura della tabella `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `cover` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `posts`
--

INSERT INTO `posts` (`id`, `author`, `category`, `title`, `content`, `cover`, `status`, `date`) VALUES
(20, 114, 6, 'Articolo1', '<p><span id=\"isPasted\" style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Bell ma pini file mani vedi le me ha. Ben attoniti convulso ama ripeteva presenza dai. Poi guardavamo rientrarvi perpetuato puo non pensieroso. Rifiutare arrestare puramente due ora brillanti. Annunziare riflettere impaziente sai ore dai. Importa tiepide tra suo lei assouan valesse. Pie dio cosi ero dito nome alla.</span><br style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><br style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Po il sedesse te fuggire ve capelli. Sua torcesse vuotarla profonda permesso sia. Amo appartiene cancellato sui gia crepitando. Il gabbiani ah rinunzia minaccia ricevuto ai un. Fretta brilla sul afa marito dio ferite. Volgendosi fa dolcemente il ne sostenendo affaticato vergognoso perfezione. Pei bruciavano commozione ricomincia seducevano perdonarmi voi. Fra sai mia quanto giunta estate resina. Tremito morissi al dattero armonia ti. Toscano blocchi doveste nel tabacco periodo dov intrusa dal.</span></p>', 'cover.png', 1, '2022-08-02 02:30:02'),
(21, 114, 7, 'Articolo2', '<p><span id=\"isPasted\" style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Scoperto mia parlando sii dolcezza far. Suo senti tuo neghi morra pei corre tenta. Vestita con trasale aridita conosco sii far. Via conosco affonda topazii superbe pur partita con accorge. Nel sul sostenere necessita solitario aspettano riempiono era. Ho dissolve speranza el in chiedere spiaggia distinte glorioso.</span><br style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><br style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Un generando el subitaneo ad aggiogati. Hai una agita colma resto. Mio che affrontare visitatore sua calpestare. Pel per limite felice poggio. Te partirsi violenza ha sa illumina divenuto ostinata. Sua afa somigliava necessario chi arrossendo avidamente pel.</span><br style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><br style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Uno partirmi voi tal inquieta smettere oleandri cenobita. Fai amai tuo tono alta dito dire pure. Tese ambo ha onde oh lana si ti fame. Ho anni dice la al sono arco. Intendeva contenuta parlavate va da puramente chiederai un scacciare. Caduco ch verita te fresca oh da. Perse udi una verra entro gizeh molte col prova.</span></p>', 'cover.png', 1, '2022-08-02 02:32:32'),
(22, 114, 8, 'Articolo3', '<p><span id=\"isPasted\" style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Oricellari esaltavano impedirgli sai fai commozione. Pulsare immensa vestita ape compiva strette dei mio sue sospiro. Vi immune gomito ah saluta. Avidita fu coperta tu si el conosci. Pel malato uscita sue domani dovrei. Sue poi due fra congiunto bisognava rapimento soggiunse.</span><br style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><br style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Nel sia guardate dissolve traversa impedire sei medesima guardare. In facendo ed la diffusa sognato girando debbano. Poi ami svegli appena pel impeto quarta. Tal avvenne capelli una cantica coperta ritorna. Ho da tipo taci alta nato pene. Vostre dai com radici mia talune afa serena. Come per suo sui stai onda par. Colma ape com legge che anima qua. Il siedi buona ah ti regge bella. Accade rivivo la morivo el oppure.</span></p>', 'cover.png', 1, '2022-08-02 02:33:58'),
(23, 114, 9, 'Articolo4', '<p><span id=\"isPasted\" style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Quarta gli chi sabbia vai intere estate. Vorrei sacchi dir per salute intere chi chiusa saluti hai. Eri valsa via steso gia alghe era. Puerile feconda ne istante miseria toccato io vedrete. In smorta piange svelto mutare rividi sabbia tu lo. Prese bel pel steso vai torno luogo venir.</span><br style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><br style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Com approdare affannata dio bisognava. Esce ogni pur uomo tra voto lui ali rose onda. Uno occhi ragia beata sapra pel. Tre piena sul fiera passi avere. Su ogni ex vana fara vidi arno oh ah. Intervallo lo giudichera trascinano me appartenga accompagno. Con cominciata ritroverai afa cui agitazione non toglieremo interrompe. Divine apriro se arcate dunque io so ti provai rapiva. La se arco vivo dell alle. Confusa or gravata santita di oh indugio audacia indugia.</span></p>', 'cover.png', 1, '2022-08-02 02:34:46'),
(24, 114, 10, 'Articolo5', '<p><span id=\"isPasted\" style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Ve cuscini sognato attende ex. Presagio plasmare eternita virtuoso ve spiaggia mi. Rianimo settala giammai me vicende oh. Ha preso ch le colma cigli mi. No diritte rientri tornare no ai pulsare chinava. Repentina sconvolta attendeva chi che narcotico. Non ogni pel pena chi file reni neve vuoi. Mi difesa si tu fronte or patito.</span><br style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><br></p>', 'cover.png', 1, '2022-08-02 02:35:10'),
(25, 114, 16, 'Articolo6', '<p><span id=\"isPasted\" style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Inquieto era ama ingombro consunta bel far. Po tardi venir verso io forse. Acerbita due par mutevole martirio. Cui avidamente the ali lui bellissima fatalmente. Cattivo dal lacrima sentito amuleti sua. Fuori ragia avete sorte uno abbia era dev. Colte chi nuovi voi cielo tre vibri. Puo vibri tocca salde cio ore.</span><br style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><br style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Tra fiera tende due tante sapro seppe manca vai. The chiave mia impeto morivo due arrivo groppa tua nostra. Indicibile dal accompagno qua tranquilla commozione. Dev sempre tal pregio audace dal sapete troppe morivo che. Dava va fine oh cane. Vivo dall da orti el ride un. Parlare ero mai antichi potenza strette gia. Stanchezza chi tuo allegrezza lui fra verrocchio animatrici. Un profonde partirsi tu profondo guardavo ho tu alterata.</span></p>', 'cover.png', 1, '2022-08-02 02:35:51'),
(26, 114, 18, 'Articolo7', '<p><span id=\"isPasted\" style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Nel nascondere dal una toglieremo ricordarmi impazienza. Fresche arteria ha le giacche miniato. Fa te omeri notti saffo dagli volle parli. Tal conservo turchese dal plasmare cui. Mai puo sete quel all tuo caro. Abisso membra ve vi ma queste. Abbozzata cio necessita riconobbe cui mie sui. Coraggiose bel impazienza sei scomparire qua ricomincia partissero.</span><br style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><br style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Ah su umilta trarre mi da dorata deliri nemica chiama. Guardavo una nel convento luminosa troverei arrivato escirgli. Ad fimo taci mi mine urto seme me buio. Entrare ve tiepide svanito deserta di balsami la so. Nevi anni riso senz ove mia otri ando. Tra incertezza misteriosa crepitando immobilita gli. Altezza cerchia iersera il ragione fa. Avro fa muto pini gote vi onde il ha.</span></p>', 'cover.png', 1, '2022-08-02 02:37:20'),
(27, 114, 6, 'Articolo1a', '<p><span id=\"isPasted\" style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Loro dita diro luce oh rote lo nudo la. Fine hai ami lega poi alpe. Rivederlo suo scintilla col modellare dov sconvolto talismani taciturna. Dai essa amai ando reni par. Visitatore appartenga mia interrompe perpetuato portartela accostarmi dev. Pensai ah so sforzo ai intero aprano brilla ho. Esercita luminosa compagna medesima potrebbe contiene ci si da.</span><br style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><br style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Nervi cigli di farai oblio buone le ti veste. Fanciullo lavorando ha ho melagrani osservava rivederci si strappato da. Punge tardi verra al in passa ed te. Comprendi ch po distrutta statuario. Col ascoltami rammarico oltremare ama. Forse sta bel campo andro sapro. Salvata su seconda divieto ritrovi ai.</span></p>', 'cover.png', 1, '2022-08-02 14:42:59'),
(28, 114, 20, 'Articolo1b', '<p><span id=\"isPasted\" style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Mattini ben lettera pel intendi. Sei ospitarvi del the abbandono sconvolta crescente nel mantenere. Al liberarli rivederci ginocchia conoscete ma crescente cresciuto. Tre ostinata trovarti cadaveri verranno sommesso tra gia sta illumina. Officio accosta fa perduta cintura pensato no vecchie un ad. Io soggiunse se sublimate la sconvolta ha torturare. Troverei tua raccogli sue suo incendio.</span><br style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><br style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;\"><span style=\"color: rgb(0, 0, 0); font-family: verdana, arial, sans-serif; font-size: 14.4px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; display: inline !important; float: none;\">Divine sabbia medici sui dei suo. Mi convulsa oh talvolta percosso travolge fu ingombro. Esistenza singolare un levandoti estenuato va. Quanto ora che dovrei invece. Lei andro sue porti poter udi fai gurge della. Avrei dei vuole col mio era molta. Cima sul voto solo tua gote pei arno. Ah torrente ma vietarle mediocre su esitanza. Su ah ritornarvi finalmente or arrossendo lineamento.</span></p>', 'cover.png', 1, '2022-08-02 14:44:40'),
(30, 114, 1, '!£$%&/()=?', '<p>!&quot;&pound;$%&amp;/()=?</p>', 'cover.png', 1, '2022-08-03 20:11:52');

-- --------------------------------------------------------

--
-- Struttura della tabella `site`
--

CREATE TABLE `site` (
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `login` tinyint(1) NOT NULL,
  `register` double NOT NULL,
  `posts` int(11) NOT NULL,
  `phrase` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `site`
--

INSERT INTO `site` (`name`, `email`, `description`, `image`, `login`, `register`, `posts`, `phrase`) VALUES
('AlessandroMasone', 'masonealessandro04@gmail.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel augue nec enim aliquet feugiat id ullamcorper ante. Suspendisse potenti. Vestibulum scelerisque tempus bibendum. Aenean ante nisi, blandit in erat egestas, tempor interdum neque. Curabitur ut orci ut ante dignissim cursus eget ac metus. Aliquam diam nunc, lacinia pharetra maximus eu, lacinia non ipsum. Aenean et magna nisl.', 'favicon1658844579509.png', 1, 1, 1, 'Lorem ipsum dolor sit amet');

-- --------------------------------------------------------

--
-- Struttura della tabella `stats`
--

CREATE TABLE `stats` (
  `id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `type` varchar(255) NOT NULL,
  `note` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `stats`
--

INSERT INTO `stats` (`id`, `value`, `date`, `type`, `note`) VALUES
(154, '::1', '2022-07-21', 'access', NULL),
(156, '::1', '2022-07-22', 'access', NULL),
(170, '::1', '2022-07-23', 'access', NULL),
(171, '::1', '2022-07-24', 'access', NULL),
(178, '::1', '2022-07-25', 'access', NULL),
(179, '::1', '2022-07-26', 'access', NULL),
(180, '::1', '2022-07-29', 'access', NULL),
(181, '::1', '2022-07-30', 'access', NULL),
(198, '::1', '2022-08-02', 'access', NULL),
(200, '::1', '2022-08-03', 'access', NULL),
(201, '::1', '2022-08-04', 'access', NULL),
(203, '::1', '2022-08-05', 'access', NULL),
(205, '::1', '2022-08-06', 'access', NULL),
(206, '::1', '2022-08-06', 'post', '30'),
(207, '::1', '2022-08-06', 'category', '1'),
(208, '::1', '2022-08-06', 'post', '28'),
(209, '::1', '2022-08-06', 'category', '20'),
(210, '::1', '2022-08-06', 'post', '27'),
(211, '::1', '2022-08-06', 'category', '6'),
(212, '::1', '2022-08-06', 'post', '20'),
(213, '::1', '2022-08-06', 'post', '23'),
(214, '::1', '2022-08-06', 'category', '9');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `code` bigint(20) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '1',
  `avatar` varchar(255) NOT NULL DEFAULT 'avatar.png',
  `reset_password_otp` varchar(255) DEFAULT NULL,
  `favorites` text,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `surname`, `email`, `password`, `code`, `status`, `type`, `avatar`, `reset_password_otp`, `favorites`, `create_at`) VALUES
(114, 'admin', 'admin', 'admin', 'admin@admin.admin', '21232f297a57a5a743894a0e4a801fc3', NULL, 1, 0, 'avatar1659392095367.png', NULL, '', '2022-08-02 00:14:55'),
(115, 'autore', 'autore', 'autore', 'autore@autore.autore', 'ccd4049f78acf64f66a9a0b4611543a0', NULL, 1, 2, 'avatar1659392291316.png', NULL, NULL, '2022-08-02 00:18:11'),
(116, 'utente', 'utente', 'utente', 'utente@utente.utente', '3ce98305181b1bac59d024a49b0ffd73', NULL, 1, 1, 'avatar.png', NULL, NULL, '2022-08-02 00:19:11');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `stats`
--
ALTER TABLE `stats`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT per la tabella `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT per la tabella `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT per la tabella `stats`
--
ALTER TABLE `stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=215;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
