@include('common.action-button.default', [
    'action'  => $action,
    'show'    => isset($show) ? $show : true,
    'confirm' => $confirm,
    'method'  => 'DELETE',
    'color'   => 'danger',
    'label'   => 'remover',
    'icon'    => 'trash',
])
