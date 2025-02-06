# Tennis Challenge Application :tennis:

## Descripción

La aplicación Tennis Challenge es una API que permite gestionar torneos de tenis. Los usuarios pueden crear, listar, filtrar y ver detalles de torneos. La aplicación está construida utilizando el framework Laravel y sigue varios patrones de diseño para asegurar un código limpio, mantenible y escalable.

## Características

- **Crear Torneos**: Permite crear nuevos torneos
- **Listar Torneos**: Permite listar todos los torneos con opciones de filtrado y paginación.
- **Filtrar Torneos**: Permite filtrar torneos por nombre, género, tipo, nombre del ganador, habilidad del ganador y fecha.
- **Ver Detalles de Torneos**: Permite ver los detalles de un torneo específico.

## Patrones de Diseño Utilizados

### 1. **Factory Pattern**
Utilizado para crear instancias de jugadores (`PlayerFactory`). Este patrón permite encapsular la creación de objetos y facilita la creación de diferentes tipos de jugadores (por ejemplo, `MalePlayer`, `FemalePlayer`).

### 2. **Strategy Pattern**
Utilizado para definir diferentes estrategias de torneo (`SingleTournamentStrategy`, `DoubleTournamentStrategy`). Este patrón permite definir una familia de algoritmos, encapsular cada uno de ellos y hacerlos intercambiables. En este caso, se utiliza para determinar el ganador de un torneo dependiendo del tipo de torneo (individual o dobles).

### 3. **Trait**
Utilizado para compartir funcionalidad común entre diferentes clases (`PlayerHelpers`). Los traits permiten reutilizar métodos en múltiples clases sin necesidad de herencia.

### 4. **Service Pattern**
Utilizado para encapsular la lógica de negocio relacionada con los torneos (`TournamentService`). Este patrón ayuda a mantener los controladores delgados y enfocados en manejar las solicitudes HTTP.

#### 5. **Event-Listener Pattern**
Utilizado para manejar eventos en la aplicación (`TournamentPlayed`, `SaveTournament`). Este patrón permite desacoplar la lógica de negocio y manejar eventos de manera asíncrona.

## Instalación

1. Clona el repositorio:

   git clone https://github.com/stephanosJAH/tennis-challenge.git

2. Instala las dependencias:

	cd tennis-challenge
	composer install

3. Configura el archivo .env:

	cp .env.example .env
	php artisan key:generate

4. Configura la base de datos en el archivo .env.

5. Ejecuta las migraciones:

	php artisan migrate

## Uso

### Endpoints 

**Lista todos los torneos.**

	GET /api/tournaments

**Muestra los detalles de un torneo específico.**

	GET /api/tournaments/{id}

**Crea un nuevo torneo.**

	POST /api/tournaments

**Actualiza un torneo existente.**

	PUT /api/tournaments/{id}

**Elimina un torneo.**

	DELETE /api/tournaments/{id}

### Filtrado

Lista de posibles filtros:

- `like`: `like` **Busqueda pacial**
- `eq`: `=`	**Busqueda exacta**
- `gt`: `>` **Busqueda mayor que**
- `lt`: `<` **Busqueda menor que**
- `lte`: `<=` **Busqueda mayor o igual que**
- `gte`: `>=` **Busqueda menor o igual que**
- `in`: `in` **Busqueda que incluye**

Filtrar por nombre exacto:

	GET /api/tournaments?name[eq]=Tournament Name

Filtrar por género:

	GET /api/tournaments?gender[eq]=male

Filtrar por habilidad del ganador mayor que:

	GET /api/tournaments?winner_skill[gt]=80

Filtrar por rango de fecha de los torneos

	GET /api/tournaments?date[gt]=2024-02-01&date[lt]=2024-04-01

### Generar torneo

**Endpoint**

	POST /api/tournaments

**Payload**

```
{
	"name": "torneo test 1",
	"gender": "female",
	"type": "single",
	"date": "2024-03-01",
	"players": [
		["Juan", 80, 10, 5],
		["Pedro", 75, 8, 6],
		["Carlos", 90, 15, 7],
		["Luis", 70, 25, 7],
		["Test", 90, 8, 4],
		["Jesus", 100, 9, 5],
		["Laura", 98, 8, 3],
		["Mica", 99, 8, 4]
	]
}
```

### Reglas Generales de validación

- **name**: 
  - `required`: El nombre del torneo es obligatorio.
  - `string`: El nombre del torneo debe ser un texto.
  - `max:255`: El nombre del torneo debe tener un máximo de 255 caracteres.
  - `unique:tournaments`: El nombre del torneo debe ser único en la tabla de torneos.

- **gender**: 
  - `required`: El género de los participantes del torneo es obligatorio.
  - `string`: El género de los participantes del torneo debe ser un texto.
  - `in:male,female`: El género de los participantes del torneo debe ser "male" o "female".

- **type**: 
  - `required`: El tipo de torneo es obligatorio.
  - `string`: El tipo de torneo debe ser un texto.
  - `in:single,double`: El tipo de torneo debe ser "single" o "double".

- **date**: 
  - `required`: La fecha del torneo es obligatoria.
  - `date`: La fecha del torneo debe ser una fecha válida.
  - `date_format:Y-m-d`: La fecha del torneo debe tener el formato `Y-m-d`.

- **players**: 
  - `required`: La lista de jugadores es obligatoria.
  - `array`: La lista de jugadores debe ser un arreglo.
  - `min:2`: La lista de jugadores debe tener al menos 2 elementos.
  - Validación personalizada:
    - La cantidad de jugadores debe ser una potencia de 2.
    - Cada jugador debe contener Nombre, habilidad, extra1 y extra2 (si es masculino).
    - El nombre del jugador debe ser un texto.
    - El skill del jugador debe ser un número entero entre 0 y 100.
    - El extra1 del jugador debe ser un número entero.
    - El extra2 del jugador debe ser un número entero (si es masculino).

## Documentation :memo:

**endpoint**

	GET /api/documentation

**generar**

	php artisan l5-swagger:generate


**Esteban Isaias Campos**
🤓