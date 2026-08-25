# FAP Text Motion

Estudio de texto animado (motion graphics) del ecosistema [Free Animation Power](https://freeanimationpower.org).

Anima textos en el navegador con 105 presets editables, fuentes de Google, timeline con scrubbing y exportacion a video con o sin transparencia.

## Demo en vivo

https://freeanimationpower.github.io/FAP_TEXTMOTION/

## Caracteristicas

- 105 animaciones editables en 20 familias: Entradas, Maquina, Espaciado, Ondas, 3D, Glitch, Rebote, Color, Trazo, Salida y ambient, Revelados, Elasticos, Liquido, Caminos, Fisica, Profundidad, Luces, Tipograficos, Ambientales y Aterrizajes
- Buscador de efectos por nombre en el panel derecho
- Edicion por letra estilo Photoshop/AE: toca una letra en el escenario, arrastrala para moverla y usa el tirador naranja para cambiar su tamano; color, rotacion y posicion fina desde el panel
- Keyframes por propiedad: anima tamano, espaciado de letras, interlineado, opacidad, rotacion y escala con puntos arrastrables en la linea de tiempo (interpolacion lineal)
- 220 fuentes de Google en un unico selector agrupado por categoria (Display, Sans Serif, Serif, Mono, Script, Decorativas y listas extra); cada nombre se muestra en su propia tipografia
- Deshacer y rehacer: Ctrl+Z / Ctrl+Y y botones en la linea de tiempo (tambien para movil)
- Diseno responsive completo para tablets y moviles
- Parametros por preset (velocidad, amplitud, potencia, ecos, etc.) + controles globales: easing (8 curvas), duracion de entrada, stagger por letra, animacion de salida espejo, bucle
- Tipografia: 16 fuentes de Google curadas + fuente personalizada de Google, peso (400/700/900), cursiva, tamano, espaciado, interlineado, alineacion
- Relleno, contorno o ambos, con colores y grosor configurables; degradados, sombras, motion blur
- Fondo activable o transparencia total (checkerboard en el escenario)
- Exportacion WebM (con canal alfa real), MOV (ProRes 4444 con alfa, compatible con After Effects/Premiere), MP4 y GIF (con transparencia), 24/30/60 fps
- Guardar y abrir proyectos JSON (.textmotion) + autoguardado en localStorage
- Atajos: ESPACIO reproduce/pausa, clic en la linea de tiempo para scrubbing

## Correr localmente

Requiere PHP 7.4+ (el archivo PHP solo usa el email gate del ecosistema; todo el motor corre en el navegador):

```
php -S localhost:8000
```

Abrir http://localhost:8000/index.php

En localhost el email gate se omite automaticamente (bypass de desarrollo). En produccion protege la herramienta con la sesion de login del hub.

## Estructura

| Archivo | Uso |
|---------|-----|
| index.php | Version de produccion con email gate (Hostinger/PHP) |
| docs/index.html | Demo estatica identica, servida por GitHub Pages |

## Stack

HTML5 + CSS3 + Vanilla JS + Canvas 2D. Cero dependencias. Motor de render determinista por tiempo: la misma funcion dibuja el preview en vivo y cada frame de exportacion.
