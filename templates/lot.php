
<section class="lot-item container">
    <h2><?=$lot['Name']?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="../<?=$lot['Image']?>" width="730" height="548">
            </div>
            <p class="lot-item__category">Категория: <span><?=$lot['Category']?></span></p>
            <p class="lot-item__description"><?=$lot['Description']?></p>
        </div>

        <div class="lot-item__right">
            <?php
            if($is_auth==1)
            {

            ?>
            <div class="lot-item__state">
                <div class="lot-item__timer timer">
                    10:54
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?=sum_format($lot['Cost'])?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?=$lot['Min']?> р</span>
                    </div>
                </div>

                <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post" autocomplete="off">
                    <p class="lot-item__form-item form__item form__item--invalid">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="text" name="cost" placeholder="<?=$lot['Min']?>">
                        <span class="form__error">Введите наименование лота</span>
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
            </div>
            <?php } ?>
            <div class="history">
                <h3>История ставок (<span><?=$lot['Bets']?></span>)</h3>
                <table class="history__list">
                    <?php
                    $cost = $lot['Cost'];
                    foreach ($bets as $bet)
                    {
                    ?>
                    <tr class="history__item">
                        <td class="history__name"><?=$bet['User_name']?></td>
                        <td class="history__price"><?=$cost?></td>
                        <td class="history__time"><?=$bet['Date_of_accommodation']?></td>
                    </tr>
                    <?php
                        $cost-=(double)$bet['Sum'];
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</section>
