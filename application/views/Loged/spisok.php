<div id="container">
    <h1Список Дел</h1>
    <form method="post" action="/welcome/logOut">
        <button type="submit">Выйти</button>
    </form>
    <div id="body">

        <form >
            Номер  :<input id="num" type="text">
            <br>
            Дело   :<input id="work" type="text">
            <br>
            Время  :<input id="date" type="text">
            <br>
        </form>
             <button id="inject" >добавить</button>


        <div id="return"><?

                        //echo "<pre>";

                        foreach ($data as $ret){

                            echo '<div>'.' sort: '.$ret->sort.'/Номер:'.$ret->num.' / Дело : '.$ret->work.' / Время : '.$ret->date.
                                '<button class="cl" value="'.$ret->id.'">delete</button>'.
                                '<button class="up">up</button>' .
                                '<button class="down">down</button></div>';
                        }

                        //echo "</pre>";


            ?></div>

    </div>
</div>
