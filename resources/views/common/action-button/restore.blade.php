@include('common.action-button.default', [
    'action'    => $action,
    'show'      => isset($show) ? $show : true,
    'confirm'   => $confirm,
    'method'    => 'PUT',
    'color'     => 'purple',
    'label'     => 'restaurar',
    'icon'      => 'recycle',
])
