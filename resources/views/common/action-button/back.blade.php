@include('common.action-button.link', [
    'action'    => navigate_back( $action ),
    'show'      => isset($show) ? $show : true,
    'color'     => 'default hidden-print',
    'label'     => 'voltar',
    'icon'      => 'chevron-left',
    'showLabel' => true,
])
