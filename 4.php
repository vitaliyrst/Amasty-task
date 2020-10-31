<?php include __DIR__ . '/simple_html_dom.php'; ?>
<div>
    <form method="post" action="4.php">
        Введите название команды: <input name="team" type="text">
        <button type="submit">Получить</button>
    </form>
    <?php $teamName = $_POST['team'];
    if (isset($teamName)) :
        $getTeam = findTeam($teamName); ?>
        <h1><?php echo $teamName ?></h1>
        <?php foreach ($getTeam[$teamName] as $name => $team) : ?>
        <p><b><?php echo $name; ?></b>
            <?php echo $team; ?></p>
    <?php endforeach;
    endif; ?>
</div>
<?php
function getAllSeasonsLinks()
{
    $html = new simple_html_dom();
    $html->load_file('https://terrikon.com/football/italy/championship/');
    $getArchiveLink = $html->find('div[id="container"] div.content-site');
    $archiveLink = '';
    foreach ($getArchiveLink as $link) {
        $archiveLink = 'https://terrikon.com' . $link->find('div.col', 1)->find('h2 a', 1)->href;
    }
    $html->load_file($archiveLink);
    $getAllSeasonsLinks = $html->find('div[id="container"] div.content-site div.maincol 
    div.tab div.news dl dd a');
    $seasonsLinks = [];
    foreach ($getAllSeasonsLinks as $link) {
        $seasonsLinks[] = 'https://terrikon.com' . $link->href;
    }
    return $seasonsLinks;
}

function findTeam($team)
{
    $html = new simple_html_dom();
    $seasonLinks = getAllSeasonsLinks();
    $teamInfo[$team] = [];
    $start = date('Y');
    $interval = date('y') + 1;
    foreach ($seasonLinks as $link) {
        $html->load_file($link);
        $table = $html->find('div[id="container"] div.content-site div.maincol 
        div.tab table[class="colored big"] tr');
        foreach ($table as $td) {
            if ($td->find('td a', 0)->plaintext == null) {
                continue;
            }
            if ($team !== $td->find('td a', 0)->plaintext) {
                continue;
            }
            $teamInfo[$team]['Сезон: ' . $start-- . '-' . $interval--] =
                'Место: ' . substr($td->find('td', 0)->plaintext, 0, 1) .
                ' Количество очков: ' . $td->find('td strong', 0)->plaintext;
        }
    }
    if (empty($teamInfo[$team])) {
        echo 'Такой команды не существует';
        die();
    }
    return $teamInfo;
}

?>
