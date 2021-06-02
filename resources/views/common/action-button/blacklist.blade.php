@include('common.action-button.default', [
    'action'  => $action,
    'show'    => isset($show) ? $show : true,
    'confirm' => $confirm,
    'method'  => 'POST',
    'color'   => 'danger',
    'label'   => 'blacklist',
    'icon'    => 'ban',
])
