<?php

namespace App\Presenters\Models;

use App\Presenters\Presenter;

/**
 * Class Game
 *
 * @property \App\Models\Game $instance
 *
 * @package App\Presenters\Models\Games
 */
class Game extends Presenter
{
    public function id()
    {
        return '#' . $this->instance->id;
    }

    public function size( $html = true )
    {
        $tokens = [];

        $tokens[] = 'Times de';
        $tokens[] = $this->instance->size;
        $tokens[] = 'jogadores';


        return $this->returnAsHTML( join( ' ', $tokens ), $html );
    }

    public function date( $html = true )
    {
        $tokens   = [];
        $tokens[] = 'marcado para';
        $tokens[] = $this->instance->date->format( self::LOCALIZED_DATE_FORMAT );

        return $this->returnAsHTML( join( ' ', $tokens ), $html );
    }

    public function confirmation( $html = true )
    {
        $tokens   = [];

        $teams = [];

        $users = $this->instance->users->sortByDesc('skill');
        $tamanho = $this->instance->size;

        $quantidade = $this->instance->users->count();

        $times = intdiv($quantidade,$tamanho);



        [$goleiros, $linha] = $users->partition(function ($i) {
            return $i->goalkeeper == 1;
        });
        
        if($quantidade < $tamanho*2){
            $tokens[] = '<p style="color:red;">Quantidade insuficiente de jogadores</p>';

            return $this->returnAsHTML( join( ' ', $tokens ), $html );

        }
        
        if($goleiros->count() < 2){
            $tokens[] = '<p style="color:red;">Quantidade insuficiente de goleiros</p>';
            return $this->returnAsHTML( join( ' ', $tokens ), $html );

        }

        if($linha->count() < $times * ($tamanho-1)){
            $tokens[] = '<p style="color:red;">Quantidade insuficiente de jogadores de linha</p>';
            return $this->returnAsHTML( join( ' ', $tokens ), $html );

        }

        // dividir os goleiros em N times para tentar colocar 1 goleiro em cada time
        for($i = 0; $i <= $times; $i++){
            if($goleiros->count() >0){
                $teams[] = collect();
                $teams[$i]= $teams[$i]->push($goleiros->shift());
            }
        }

        // retirar sempre o primeiro elemento e inserir no grupo do goleiro com a menor soma de habilidades de todos os jogadores, respeitando o limite de jogadores
        $quantidade = $linha->count();
        
        while($quantidade > 0){

            $menor_valor = 9999;
            $menor_indice = 9999;

            for($i = 0; $i < count($teams);$i++){
                if($teams[$i]->count() < $tamanho){
                    $sum = $teams[$i]->sum('skill');
                    if($sum < $menor_valor){
                        $menor_valor = $sum;
                        $menor_indice = $i;
                    }
                }
            }
            if($menor_indice < count($teams)){
                $teams[$menor_indice] = $teams[$menor_indice]->push($linha->shift());

            }
            $quantidade--;
        }

        $linha->concat($goleiros);

        $restos = $linha->chunk(2);
        

        foreach($restos as $resto){
            $teams[] = $resto;
        }

        // colocar os jogadores restantes em times de n jogadores, com ou sem goleiro
        foreach($teams as $key => $team){
            $tokens[] = '<p>Time ' . $key+1 . '</p>';
            foreach($team as $player){
                $tokens[] = '<p>' . $player->name . ($player->goalkeeper?' - goleiro':' - linha') . ' - habilidade: '.$player->skill . '</p>';

            }
        }


        return $this->returnAsHTML( join( ' ', $tokens ), $html );
    }

    public function comment_preview($html = true)
    {
        $tokens   = [];
        $tokens[] = substr($this->instance->comment, 0, 255);
        $tokens[] = '<p>[...]</p>';
        return $this->returnAsHTML( join( ' ', $tokens ), $html );

    }


    public function updated_at()
    {
        if (is_null( $this->instance->updated_at )) {
            return null;
        }

        if ($this->instance->updated_at->eq( $this->instance->created_at )) {
            return null;
        }

        return parent::updated_at();
    }
}
