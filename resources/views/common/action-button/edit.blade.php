@include('common.action-button.link', [
    'action'  => $action,
    'show'    => isset($show) ? $show : true,
    'color'   => 'warning',
    'label'   => 'inscrever',
    'icon'    => 'pencil-alt',
])
