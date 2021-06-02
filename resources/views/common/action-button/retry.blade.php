@include('common.action-button.default', [
    'action'  => $action,
    'show'    => isset($show) ? $show : true,
    'confirm' => $confirm,
    'method'  => 'PATCH',
    'color'   => 'info',
    'label'   => 'reprocessar',
    'icon'    => 'recycle',
])
