<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Datos Exportados</h1>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Descripcion</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($imagenes as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->nombre }}</td>
                    <td>
                        @if ($item->imagen)
                            <img src="{{ public_path('storage/' . $item->imagen) }}" alt="{{ $item->nombre }}"
                                width="100">
                        @else
                            Sin imagen
                        @endif
                    </td>
                    <td>{{ $item->descripcion }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
