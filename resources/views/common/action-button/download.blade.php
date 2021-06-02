@include('common.action-button.link', [
    'action'   => $action,
    'show'     => isset($show) ? $show : true,
    'color'    => 'default',
    'label'    => 'download',
    'icon'     => 'download',
])
