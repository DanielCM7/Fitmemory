-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-03-2026 a las 21:06:04
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `fitmemory`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes_entrenadores`
--

CREATE TABLE `clientes_entrenadores` (
  `id_cliente` int(11) NOT NULL,
  `id_entrenador` int(11) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejercicios`
--

CREATE TABLE `ejercicios` (
  `id_ejercicio` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `maquina_material` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ejercicios`
--

INSERT INTO `ejercicios` (`id_ejercicio`, `id_grupo`, `nombre`, `descripcion`, `maquina_material`) VALUES
(1, 1, 'Press banca con barra', 'Ejercicio básico para pectoral en banco plano', 'barra y banco'),
(2, 1, 'Press banca con mancuernas', 'Trabajo de pectoral con recorrido libre', 'mancuernas y banco'),
(3, 1, 'Press inclinado con barra', 'Trabajo de la parte superior del pectoral', 'barra y banco inclinado'),
(4, 1, 'Press inclinado con mancuernas', 'Trabajo superior de pecho con mancuernas', 'mancuernas y banco inclinado'),
(5, 1, 'Aperturas con mancuernas', 'Aislamiento de pectoral en banco', 'mancuernas y banco'),
(6, 1, 'Cruce de poleas', 'Aislamiento de pectoral con poleas', 'polea'),
(7, 1, 'Peck deck', 'Apertura guiada para pectoral', 'maquina'),
(8, 1, 'Fondos para pecho', 'Fondos inclinando el torso para enfatizar pectoral', 'paralelas'),
(9, 1, 'Push up', 'Flexiones de pecho con peso corporal', 'sin material'),
(10, 2, 'Dominadas', 'Trabajo de espalda con peso corporal', 'barra fija'),
(11, 2, 'Jalon al pecho', 'Trabajo de dorsal en polea alta', 'polea'),
(12, 2, 'Remo con barra', 'Trabajo de espalda media', 'barra'),
(13, 2, 'Remo con mancuerna', 'Remo unilateral para dorsal y espalda media', 'mancuerna'),
(14, 2, 'Remo en polea baja', 'Trabajo de espalda con polea', 'polea'),
(15, 2, 'Remo en maquina', 'Trabajo guiado para espalda', 'maquina'),
(16, 2, 'Pullover en polea', 'Ejercicio para dorsal ancho', 'polea'),
(17, 2, 'Remo en T', 'Trabajo de espalda con barra T', 'maquina o barra T'),
(18, 2, 'Face pull', 'Trabajo de espalda alta y deltoide posterior', 'polea'),
(19, 3, 'Curl con barra', 'Ejercicio básico de bíceps', 'barra'),
(20, 3, 'Curl con barra Z', 'Curl de bíceps con agarre comodo', 'barra Z'),
(21, 3, 'Curl alterno con mancuernas', 'Trabajo unilateral de bíceps', 'mancuernas'),
(22, 3, 'Curl martillo', 'Trabajo de bíceps y braquial', 'mancuernas'),
(23, 3, 'Curl concentrado', 'Aislamiento de bíceps', 'mancuerna'),
(24, 3, 'Curl predicador', 'Curl apoyado para aislar bíceps', 'banco predicador'),
(25, 3, 'Curl en polea baja', 'Curl de bíceps con resistencia continua', 'polea'),
(26, 3, 'Curl en banco inclinado', 'Trabajo de bíceps con mayor estiramiento', 'mancuernas y banco'),
(27, 4, 'Press frances', 'Trabajo de tríceps tumbado', 'barra Z'),
(28, 4, 'Extension de tricep en polea', 'Trabajo de tríceps en polea alta', 'polea'),
(29, 4, 'Extension con cuerda', 'Trabajo de tríceps con cuerda', 'polea'),
(30, 4, 'Fondos para tricep', 'Trabajo de tríceps en paralelas o banco', 'paralelas o banco'),
(31, 4, 'Press cerrado', 'Press con agarre cerrado para tríceps', 'barra y banco'),
(32, 4, 'Extension por encima de la cabeza', 'Trabajo de tríceps con mancuerna', 'mancuerna'),
(33, 4, 'Patada de tricep', 'Aislamiento de tríceps', 'mancuerna'),
(34, 4, 'Tricep en maquina', 'Trabajo guiado de tríceps', 'maquina'),
(35, 5, 'Press militar con barra', 'Ejercicio básico de hombro', 'barra'),
(36, 5, 'Press militar con mancuernas', 'Trabajo de hombro con recorrido libre', 'mancuernas'),
(37, 5, 'Elevaciones laterales', 'Aislamiento del deltoide lateral', 'mancuernas'),
(38, 5, 'Elevaciones frontales', 'Trabajo del deltoide anterior', 'mancuernas o disco'),
(39, 5, 'Pajaros', 'Trabajo del deltoide posterior', 'mancuernas'),
(40, 5, 'Press Arnold', 'Variante de press para hombro', 'mancuernas'),
(41, 5, 'Remo al menton', 'Trabajo de hombro y trapecio', 'barra'),
(42, 5, 'Hombro en maquina', 'Press guiado para hombros', 'maquina'),
(43, 6, 'Crunch', 'Trabajo basico de abdominal', 'sin material'),
(44, 6, 'Crunch en maquina', 'Trabajo guiado de abdominal', 'maquina'),
(45, 6, 'Elevacion de piernas', 'Trabajo de abdomen inferior', 'banco o barra'),
(46, 6, 'Plancha', 'Trabajo isometrico de core', 'sin material'),
(47, 6, 'Plancha lateral', 'Trabajo lateral del core', 'sin material'),
(48, 6, 'Russian twist', 'Trabajo rotacional de abdomen', 'disco o sin material'),
(49, 6, 'Encogimiento inverso', 'Trabajo de abdomen inferior', 'banco'),
(50, 6, 'Mountain climbers', 'Trabajo dinamico de core', 'sin material'),
(51, 7, 'Hiperextensiones', 'Trabajo de la zona lumbar', 'banco lumbar'),
(52, 7, 'Buenos dias', 'Trabajo de cadena posterior y lumbar', 'barra'),
(53, 7, 'Superman', 'Trabajo lumbar con peso corporal', 'sin material'),
(54, 7, 'Peso muerto rumano', 'Trabajo de cadena posterior con enfasis lumbar', 'barra'),
(55, 7, 'Peso muerto convencional', 'Ejercicio completo con fuerte trabajo lumbar', 'barra'),
(56, 8, 'Hip thrust', 'Ejercicio principal para gluteo', 'barra y banco'),
(57, 8, 'Puente de gluteo', 'Trabajo de gluteo con apoyo en suelo o banco', 'barra o sin material'),
(58, 8, 'Patada de gluteo en polea', 'Aislamiento de gluteo', 'polea'),
(59, 8, 'Patada de gluteo en maquina', 'Trabajo guiado de gluteo', 'maquina'),
(60, 8, 'Abduccion de cadera', 'Trabajo de gluteo medio', 'maquina'),
(61, 8, 'Sentadilla sumo', 'Trabajo de gluteo y pierna', 'barra o mancuerna'),
(62, 8, 'Zancada atras', 'Trabajo unilateral con enfasis en gluteo', 'mancuernas'),
(63, 8, 'Pull through', 'Trabajo de gluteo con polea', 'polea'),
(64, 9, 'Sentadilla con barra', 'Ejercicio principal de cuadricep y pierna', 'barra'),
(65, 9, 'Sentadilla frontal', 'Mayor enfasis en cuadricep', 'barra'),
(66, 9, 'Prensa de piernas', 'Trabajo de cuadricep en maquina', 'maquina'),
(67, 9, 'Extension de cuadricep', 'Aislamiento de cuadricep', 'maquina'),
(68, 9, 'Zancadas caminando', 'Trabajo unilateral de cuadricep', 'mancuernas'),
(69, 9, 'Sentadilla bulgara', 'Trabajo unilateral de cuadricep y gluteo', 'mancuernas'),
(70, 9, 'Step up', 'Subida a banco para cuadricep', 'banco y mancuerna'),
(71, 9, 'Hack squat', 'Trabajo guiado de cuadricep', 'maquina'),
(72, 10, 'Curl femoral tumbado', 'Trabajo de isquiotibial', 'maquina'),
(73, 10, 'Curl femoral sentado', 'Trabajo de isquiotibial', 'maquina'),
(74, 10, 'Peso muerto rumano', 'Trabajo de isquiotibial y gluteo', 'barra'),
(75, 10, 'Peso muerto piernas rigidas', 'Trabajo posterior de pierna', 'barra'),
(76, 10, 'Buenos dias', 'Trabajo de isquiotibial y lumbar', 'barra'),
(77, 10, 'Nordic curl', 'Trabajo intenso de isquiotibial', 'sin material o soporte'),
(78, 11, 'Elevacion de talones de pie', 'Trabajo de gemelo de pie', 'maquina o barra'),
(79, 11, 'Elevacion de talones sentado', 'Trabajo de gemelo sentado', 'maquina'),
(80, 11, 'Elevacion de talones en prensa', 'Trabajo de gemelo en prensa', 'maquina'),
(81, 11, 'Elevacion de talones a una pierna', 'Trabajo unilateral de gemelo', 'sin material o mancuerna'),
(82, 1, 'Press en máquina convergente', 'Trabajo guiado de pectoral', 'maquina'),
(83, 1, 'Aperturas en polea baja', 'Aislamiento de pectoral con poleas', 'polea'),
(84, 1, 'Press inclinado en máquina', 'Trabajo superior de pectoral', 'maquina'),
(85, 1, 'Flexiones declinadas', 'Flexiones con pies elevados', 'sin material'),
(86, 2, 'Jalon con agarre neutro', 'Trabajo de dorsal en polea', 'polea'),
(87, 2, 'Remo con pecho apoyado', 'Remo con apoyo para espalda media', 'maquina o banco'),
(88, 2, 'Dominadas asistidas', 'Variante asistida de dominadas', 'maquina'),
(89, 2, 'Encogimientos con mancuernas', 'Trabajo de trapecio', 'mancuernas'),
(90, 3, 'Curl spider', 'Aislamiento de bíceps en banco', 'banco y mancuerna'),
(91, 3, 'Curl inverso con barra', 'Trabajo de bíceps y antebrazo', 'barra'),
(92, 3, 'Curl alterno supinando', 'Curl unilateral con giro', 'mancuernas'),
(93, 3, 'Curl de arrastre con barra', 'Variante de bíceps con barra', 'barra'),
(94, 4, 'Rompecráneos con barra Z', 'Extensión tumbado para tríceps', 'barra Z'),
(95, 4, 'Extension unilateral en polea', 'Trabajo unilateral de tríceps', 'polea'),
(96, 4, 'Kickback en polea', 'Aislamiento de tríceps', 'polea'),
(97, 4, 'Press cerrado en multipower', 'Trabajo de tríceps en guiado', 'multipower'),
(98, 5, 'Elevaciones laterales en máquina', 'Trabajo guiado de hombro lateral', 'maquina'),
(99, 5, 'Peck deck inverso', 'Trabajo del deltoide posterior', 'maquina'),
(100, 5, 'Y-raise con mancuernas', 'Trabajo de hombro y estabilidad escapular', 'mancuernas'),
(101, 5, 'Remo alto en polea', 'Trabajo de hombro superior', 'polea'),
(102, 6, 'Crunch en polea', 'Trabajo abdominal con resistencia', 'polea'),
(103, 6, 'Dead bug', 'Trabajo de core y control lumbo-pélvico', 'sin material'),
(104, 6, 'Rueda abdominal', 'Trabajo avanzado de abdomen', 'ab wheel'),
(105, 6, 'Pallof press', 'Trabajo antirotacional del core', 'polea o banda'),
(106, 7, 'Extension lumbar en máquina', 'Trabajo guiado de lumbar', 'maquina'),
(107, 7, 'Hiperextension a 45 grados', 'Trabajo de zona lumbar', 'banco lumbar'),
(108, 7, 'Back extension con disco', 'Trabajo lumbar con carga', 'banco y disco'),
(109, 7, 'Peso muerto con trap bar', 'Trabajo de cadena posterior', 'trap bar'),
(110, 8, 'Hip thrust unilateral', 'Trabajo unilateral de glúteo', 'banco'),
(111, 8, 'Monster walks', 'Trabajo de glúteo medio', 'banda'),
(112, 8, 'Frog pumps', 'Aislamiento de glúteo', 'sin material'),
(113, 8, 'Curtsy lunge', 'Trabajo de glúteo y pierna', 'mancuernas'),
(114, 9, 'Sissy squat', 'Aislamiento de cuadriceps', 'sin material o soporte'),
(115, 9, 'Belt squat', 'Trabajo de cuadriceps con cinturón', 'maquina'),
(116, 9, 'Wall sit', 'Trabajo isométrico de cuadriceps', 'sin material'),
(117, 9, 'Prensa unilateral', 'Trabajo unilateral de cuadriceps', 'maquina'),
(118, 10, 'Curl femoral unilateral', 'Trabajo unilateral de isquiotibial', 'maquina'),
(119, 10, 'Curl femoral en fitball', 'Trabajo posterior de pierna', 'fitball'),
(120, 10, 'Peso muerto a una pierna', 'Trabajo de isquiotibial y equilibrio', 'mancuerna'),
(121, 10, 'Curl nórdico asistido', 'Trabajo intenso de isquiotibial', 'soporte'),
(122, 11, 'Gemelo en donkey machine', 'Trabajo de gemelo en máquina', 'maquina'),
(123, 11, 'Gemelo unilateral en escalón', 'Trabajo unilateral de gemelo', 'escalon'),
(124, 11, 'Farmer walk de puntillas', 'Trabajo de gemelo y estabilidad', 'mancuernas'),
(125, 11, 'Gemelo en multipower', 'Elevacion de talones en guiado', 'multipower'),
(126, 1, 'Press con agarre cerrado en maquina', 'Variante guiada de empuje para pectoral', 'maquina'),
(127, 1, 'Press unilateral en polea', 'Trabajo unilateral de pectoral con polea', 'polea'),
(128, 1, 'Aperturas en banco declinado', 'Aislamiento de pectoral en banco declinado', 'mancuernas y banco'),
(129, 1, 'Press con kettlebell en banco', 'Trabajo de pectoral con kettlebell', 'kettlebell y banco'),
(130, 1, 'Svend press', 'Compresion de disco para activar pectoral', 'disco'),
(131, 1, 'Pullover con barra', 'Trabajo de pecho y caja toracica', 'barra y banco'),
(132, 1, 'Press alterno con mancuernas', 'Empuje alternando brazos', 'mancuernas y banco'),
(133, 1, 'Flexiones con manos juntas', 'Variante de flexion con mayor enfasis interno', 'sin material'),
(134, 2, 'Jalon unilateral en polea', 'Trabajo unilateral de dorsal', 'polea'),
(135, 2, 'Remo Pendlay', 'Remo explosivo desde el suelo', 'barra'),
(136, 2, 'Seal row', 'Remo con pecho totalmente apoyado', 'barra y banco'),
(137, 2, 'Remo invertido en barra', 'Trabajo de espalda con peso corporal', 'barra'),
(138, 2, 'Straight arm pulldown', 'Jalon de brazos rectos para dorsal', 'polea'),
(139, 2, 'Meadow row', 'Remo unilateral en barra landmine', 'barra landmine'),
(140, 2, 'Dominada escapular', 'Trabajo de control escapular en barra', 'barra fija'),
(141, 2, 'Pulldown con brazos semirrigidos', 'Variante de jalon para dorsal', 'polea'),
(142, 3, 'Curl Zottman', 'Curl con supinacion y bajada en prono', 'mancuernas'),
(143, 3, 'Drag curl en multipower', 'Variante de curl con trayectoria pegada al cuerpo', 'multipower'),
(144, 3, 'Curl en polea tras espalda', 'Curl con brazo retrasado para mas estiramiento', 'polea'),
(145, 3, 'Curl tipo predicador en maquina unilateral', 'Aislamiento unilateral de bicep', 'maquina'),
(146, 3, 'Curl de pie con banda', 'Curl con resistencia elastica', 'banda'),
(147, 3, 'Curl 21', 'Metodo de 21 repeticiones por rangos', 'barra o mancuerna'),
(148, 3, 'Curl martillo cruzado', 'Curl hacia hombro contrario', 'mancuernas'),
(149, 3, 'Curl inclinado alterno', 'Curl unilateral en banco inclinado', 'mancuernas y banco'),
(150, 4, 'Extension de tricep con barra recta en polea', 'Empuje de tricep con barra', 'polea'),
(151, 4, 'Extension cruzada unilateral', 'Tricep unilateral cruzando el brazo', 'polea'),
(152, 4, 'Press de banca con board press', 'Variante parcial con enfasis en tricep', 'barra y banco'),
(153, 4, 'Fondos entre bancos', 'Trabajo de tricep con peso corporal', 'bancos'),
(154, 4, 'Extension de tricep en maquina sentado', 'Trabajo guiado sentado', 'maquina'),
(155, 4, 'Press Tate', 'Variante con mancuernas para tricep', 'mancuernas y banco'),
(156, 4, 'Extension de tricep con banda', 'Trabajo de tricep con banda elastica', 'banda'),
(157, 4, 'Pushdown invertido', 'Empuje en polea con agarre supino', 'polea'),
(158, 5, 'Cuban press', 'Movimiento combinado para hombro y rotadores', 'mancuernas'),
(159, 5, 'Press landmine a una mano', 'Empuje diagonal para hombro', 'barra landmine'),
(160, 5, 'Elevacion lateral sentado', 'Aislamiento lateral controlado', 'mancuernas'),
(161, 5, 'Elevacion lateral inclinada en polea', 'Lateral con tension constante', 'polea'),
(162, 5, 'Pajaro unilateral en polea', 'Trabajo posterior unilateral', 'polea'),
(163, 5, 'Face pull con rotacion externa', 'Trabajo posterior y manguito rotador', 'polea'),
(164, 5, 'Press Bradford', 'Variante de press para hombro', 'barra'),
(165, 5, 'Wall slide', 'Trabajo de movilidad y control escapular', 'sin material'),
(166, 6, 'Crunch bicicleta', 'Trabajo abdominal con rotacion', 'sin material'),
(167, 6, 'Plank saw', 'Plancha deslizante hacia delante y atras', 'toalla o sliders'),
(168, 6, 'Body saw en TRX', 'Trabajo de core en suspension', 'TRX'),
(169, 6, 'Dragon flag asistido', 'Ejercicio avanzado de abdomen', 'banco'),
(170, 6, 'Crunch declinado', 'Abdominal en banco declinado', 'banco'),
(171, 6, 'Knee tuck en TRX', 'Flexion de rodillas en suspension', 'TRX'),
(172, 6, 'Side plank reach through', 'Plancha lateral con rotacion', 'sin material'),
(173, 6, 'Toe tap alterno', 'Trabajo de abdomen con piernas elevadas', 'sin material'),
(174, 7, 'Good morning con banda', 'Bisagra de cadera con resistencia elastica', 'banda'),
(175, 7, 'Back extension isometrico', 'Mantenimiento isometrico lumbar', 'banco lumbar'),
(176, 7, 'Hip hinge con palo', 'Aprendizaje de patron de bisagra', 'palo'),
(177, 7, 'Peso muerto maleta', 'Trabajo unilateral de cadena posterior', 'mancuerna o kettlebell'),
(178, 7, 'Superman con pausa', 'Extension lumbar con isometria', 'sin material'),
(179, 7, 'Extension lumbar en fitball', 'Trabajo de zona lumbar sobre pelota', 'fitball'),
(180, 8, 'Hip thrust con banda', 'Hip thrust con resistencia adicional', 'banda'),
(181, 8, 'B stance hip thrust', 'Variante semilateral de gluteo', 'barra y banco'),
(182, 8, 'Cable pull back', 'Patada posterior para gluteo', 'polea'),
(183, 8, 'Fire hydrant', 'Trabajo de gluteo medio', 'sin material o banda'),
(184, 8, 'Donkey kick', 'Patada atras para gluteo', 'sin material o banda'),
(185, 8, 'Lateral band walk', 'Caminata lateral para gluteo medio', 'banda'),
(186, 8, 'Hip abduction de pie en polea', 'Abduccion unilateral', 'polea'),
(187, 8, 'Single leg glute bridge', 'Puente unilateral de gluteo', 'sin material'),
(188, 9, 'Cyclist squat', 'Sentadilla con talones elevados', 'disco o wedge'),
(189, 9, 'Peterson step up', 'Trabajo especifico de cuadricep y rodilla', 'step'),
(190, 9, 'Spanish squat', 'Sentadilla con banda enfatizando cuadricep', 'banda'),
(191, 9, 'Terminal knee extension', 'Extension final de rodilla', 'banda o polea'),
(192, 9, 'Reverse nordic', 'Trabajo intenso de cuadricep', 'sin material'),
(193, 9, 'Heel elevated goblet squat', 'Goblet squat con talones elevados', 'mancuerna'),
(194, 9, 'Front foot elevated split squat', 'Split squat con apoyo delantero elevado', 'mancuernas'),
(195, 9, 'Leg extension con pausa', 'Extension de cuadricep con isometria', 'maquina'),
(196, 10, 'Romanian deadlift con kettlebell', 'Bisagra de cadera para isquios', 'kettlebell'),
(197, 10, 'Single leg Romanian deadlift', 'Trabajo unilateral de isquiotibial', 'mancuerna o kettlebell'),
(198, 10, 'Slider leg curl', 'Curl femoral con deslizamiento', 'toalla o sliders'),
(199, 10, 'Glute ham raise', 'Trabajo de isquios en maquina', 'maquina'),
(200, 10, 'Seated good morning', 'Bisagra sentado para cadena posterior', 'barra'),
(201, 10, 'Hamstring walkout', 'Trabajo de isquios desde puente', 'sin material'),
(202, 10, 'Cable leg curl', 'Curl de pierna con polea', 'polea'),
(203, 10, 'Staggered Romanian deadlift', 'RDL con apoyo asimetrico', 'barra o mancuerna'),
(204, 11, 'Calf raise en Smith', 'Elevacion de talones en multipower', 'multipower'),
(205, 11, 'Calf raise con barra de pie', 'Gemelo de pie con barra', 'barra'),
(206, 11, 'Calf raise con mancuerna sentado', 'Trabajo sentado de soleo', 'mancuerna y banco'),
(207, 11, 'Tibialis raise', 'Trabajo del tibial anterior', 'sin material o maquina'),
(208, 11, 'Jump rope rebound', 'Trabajo reactivo de tobillo y gemelo', 'comba'),
(209, 11, 'Seated bent knee calf raise', 'Gemelo sentado con rodilla flexionada', 'maquina o peso libre'),
(210, 11, 'Single leg calf raise con pausa', 'Elevacion unilateral con isometria', 'sin material'),
(211, 11, 'Calf press en hack squat', 'Empuje de gemelo en hack', 'maquina');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos_musculares`
--

CREATE TABLE `grupos_musculares` (
  `id_grupo` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupos_musculares`
--

INSERT INTO `grupos_musculares` (`id_grupo`, `nombre`, `descripcion`) VALUES
(1, 'pectoral', ''),
(2, 'espalda', ''),
(3, 'bícep', ''),
(4, 'trícep', ''),
(5, 'hombro', ''),
(6, 'abdominal', ''),
(7, 'lumbar', ''),
(8, 'gluteo', ''),
(9, 'cuadricep', ''),
(10, 'isquiotibial', ''),
(11, 'gemelo', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`) VALUES
(1, 'cliente'),
(2, 'entrenador'),
(3, 'administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutinas`
--

CREATE TABLE `rutinas` (
  `id_rutina` int(10) NOT NULL,
  `id_usuario` int(10) NOT NULL,
  `id_entrenador` int(10) DEFAULT NULL,
  `nombre_rutina` varchar(255) NOT NULL,
  `objetivo` varchar(255) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `activa` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rutinas`
--

INSERT INTO `rutinas` (`id_rutina`, `id_usuario`, `id_entrenador`, `nombre_rutina`, `objetivo`, `fecha_inicio`, `fecha_fin`, `activa`) VALUES
(1, 1, NULL, 'Rutina full body David', 'Mejorar fuerza general', '2026-03-08 19:58:34', NULL, 1),
(2, 2, NULL, 'Rutina tren inferior Paula', 'Tonificar y fortalecer piernas y gluteos', '2026-03-08 19:58:34', NULL, 1),
(3, 3, NULL, 'Rutina espalda y biceps Daniel', 'Desarrollar espalda y brazos', '2026-03-08 19:58:34', NULL, 1),
(4, 4, NULL, 'Rutina pecho hombro triceps Itziar', 'Mejorar tren superior', '2026-03-08 19:58:34', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutinas_ejercicios`
--

CREATE TABLE `rutinas_ejercicios` (
  `id_rutina_ejercicio` int(11) NOT NULL,
  `id_rutina` int(11) NOT NULL,
  `id_ejercicio` int(11) NOT NULL,
  `orden` int(11) NOT NULL,
  `series_previstas` int(11) NOT NULL,
  `repeticiones_previstas` int(11) NOT NULL,
  `peso_previsto` decimal(5,2) DEFAULT NULL,
  `descanso_previsto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rutinas_ejercicios`
--

INSERT INTO `rutinas_ejercicios` (`id_rutina_ejercicio`, `id_rutina`, `id_ejercicio`, `orden`, `series_previstas`, `repeticiones_previstas`, `peso_previsto`, `descanso_previsto`) VALUES
(1, 1, 64, 1, 4, 10, 40.00, 90),
(2, 1, 1, 2, 4, 10, 35.00, 90),
(3, 1, 10, 3, 3, 8, NULL, 120),
(4, 1, 35, 4, 3, 12, 20.00, 60),
(5, 1, 43, 5, 3, 15, NULL, 45),
(6, 2, 56, 1, 4, 12, 50.00, 90),
(7, 2, 66, 2, 4, 12, 80.00, 90),
(8, 2, 67, 3, 4, 15, 25.00, 60),
(9, 2, 60, 4, 4, 15, NULL, 45),
(10, 2, 78, 5, 4, 20, NULL, 45),
(11, 3, 11, 1, 4, 12, 35.00, 90),
(12, 3, 12, 2, 4, 10, 45.00, 90),
(13, 3, 13, 3, 3, 12, 20.00, 75),
(14, 3, 19, 4, 4, 12, 15.00, 60),
(15, 3, 22, 5, 3, 12, 12.00, 60),
(16, 4, 2, 1, 4, 10, 20.00, 90),
(17, 4, 36, 2, 4, 12, 10.00, 60),
(18, 4, 37, 3, 3, 15, 6.00, 45),
(19, 4, 28, 4, 4, 12, 15.00, 60),
(20, 4, 29, 5, 3, 12, 12.00, 60);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesiones`
--

CREATE TABLE `sesiones` (
  `id_sesion` int(10) NOT NULL,
  `id_usuario` int(10) NOT NULL,
  `fecha` datetime NOT NULL,
  `comentario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesiones_ejercicios`
--

CREATE TABLE `sesiones_ejercicios` (
  `id_sesion_ejercicio` int(11) NOT NULL,
  `id_sesion` int(11) NOT NULL,
  `id_ejercicio` int(11) NOT NULL,
  `num_serie` int(11) NOT NULL,
  `repeticion_real` int(11) NOT NULL,
  `peso_real` decimal(5,2) NOT NULL,
  `descanso_real` int(11) NOT NULL,
  `rpe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(10) NOT NULL,
  `id_rol` int(10) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `edad` int(10) NOT NULL,
  `contrasenia_hash` varchar(255) NOT NULL,
  `perfil` enum('cliente','entrenador','','') NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `activo` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `id_rol`, `nombre`, `apellidos`, `edad`, `contrasenia_hash`, `perfil`, `fecha_registro`, `activo`) VALUES
(1, 1, 'David', 'Hernandez Rodriguez', 33, '1234567890', 'cliente', '2026-03-08 19:54:38', 1),
(2, 2, 'Paula', 'Serrano Torrecillas', 33, '1234567890', 'cliente', '2026-03-08 19:54:24', 1),
(3, 1, 'Daniel', 'Cortés Martín', 33, '123456789', 'cliente', '2026-03-08 19:51:14', 1),
(4, 1, ' Itziar', 'Etxebeste Etxeberria', 33, '123456789', 'cliente', '2026-03-08 19:51:14', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes_entrenadores`
--
ALTER TABLE `clientes_entrenadores`
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_entrenador` (`id_entrenador`);

--
-- Indices de la tabla `ejercicios`
--
ALTER TABLE `ejercicios`
  ADD PRIMARY KEY (`id_ejercicio`),
  ADD KEY `id_grupo` (`id_grupo`);

--
-- Indices de la tabla `grupos_musculares`
--
ALTER TABLE `grupos_musculares`
  ADD PRIMARY KEY (`id_grupo`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `rutinas`
--
ALTER TABLE `rutinas`
  ADD PRIMARY KEY (`id_rutina`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_entrenador` (`id_entrenador`);

--
-- Indices de la tabla `rutinas_ejercicios`
--
ALTER TABLE `rutinas_ejercicios`
  ADD PRIMARY KEY (`id_rutina_ejercicio`),
  ADD KEY `id_rutina` (`id_rutina`),
  ADD KEY `id_ejercicio` (`id_ejercicio`);

--
-- Indices de la tabla `sesiones`
--
ALTER TABLE `sesiones`
  ADD PRIMARY KEY (`id_sesion`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `sesiones_ejercicios`
--
ALTER TABLE `sesiones_ejercicios`
  ADD PRIMARY KEY (`id_sesion_ejercicio`),
  ADD KEY `id_sesion` (`id_sesion`),
  ADD KEY `id_ejercicio` (`id_ejercicio`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ejercicios`
--
ALTER TABLE `ejercicios`
  MODIFY `id_ejercicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT de la tabla `grupos_musculares`
--
ALTER TABLE `grupos_musculares`
  MODIFY `id_grupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `rutinas`
--
ALTER TABLE `rutinas`
  MODIFY `id_rutina` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `rutinas_ejercicios`
--
ALTER TABLE `rutinas_ejercicios`
  MODIFY `id_rutina_ejercicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `sesiones`
--
ALTER TABLE `sesiones`
  MODIFY `id_sesion` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sesiones_ejercicios`
--
ALTER TABLE `sesiones_ejercicios`
  MODIFY `id_sesion_ejercicio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes_entrenadores`
--
ALTER TABLE `clientes_entrenadores`
  ADD CONSTRAINT `clientes_entrenadores_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `usuarios` (`id_usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `clientes_entrenadores_ibfk_2` FOREIGN KEY (`id_entrenador`) REFERENCES `usuarios` (`id_usuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `ejercicios`
--
ALTER TABLE `ejercicios`
  ADD CONSTRAINT `ejercicios_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupos_musculares` (`id_grupo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `rutinas`
--
ALTER TABLE `rutinas`
  ADD CONSTRAINT `rutinas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `rutinas_ibfk_2` FOREIGN KEY (`id_entrenador`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `rutinas_ejercicios`
--
ALTER TABLE `rutinas_ejercicios`
  ADD CONSTRAINT `rutinas_ejercicios_ibfk_1` FOREIGN KEY (`id_rutina`) REFERENCES `rutinas` (`id_rutina`) ON UPDATE CASCADE,
  ADD CONSTRAINT `rutinas_ejercicios_ibfk_2` FOREIGN KEY (`id_ejercicio`) REFERENCES `ejercicios` (`id_ejercicio`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `sesiones`
--
ALTER TABLE `sesiones`
  ADD CONSTRAINT `sesiones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `sesiones_ejercicios`
--
ALTER TABLE `sesiones_ejercicios`
  ADD CONSTRAINT `sesiones_ejercicios_ibfk_1` FOREIGN KEY (`id_sesion`) REFERENCES `sesiones` (`id_sesion`) ON UPDATE CASCADE,
  ADD CONSTRAINT `sesiones_ejercicios_ibfk_2` FOREIGN KEY (`id_ejercicio`) REFERENCES `ejercicios` (`id_ejercicio`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
