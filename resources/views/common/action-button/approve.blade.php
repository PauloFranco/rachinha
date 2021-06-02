@include('common.action-button.default', [
    'action'  => $action,
    'show'    => isset($show) ? $show : true,
    'confirm' => $confirm,
    'method'  => 'PATCH',
    'color'   => 'success',
    'label'   => 'aprovar',
    'icon'    => 'check',
])
