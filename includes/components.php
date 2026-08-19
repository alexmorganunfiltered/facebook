<?php
declare(strict_types=1);

require_once __DIR__ . '/siteHelpers.php';

/**
 * @return list<array{id: string, label: string, label_si: string}>
 */
function aswproject_nav_items(): array
{
    return [
        ['id' => 'home', 'label' => 'Home', 'label_si' => 'මුල් පිටුව'],
        ['id' => 'articles', 'label' => 'Articles', 'label_si' => 'ලිපi'],
        ['id' => 'policy-comparison', 'label' => 'Policy comparisons', 'label_si' => 'ප්‍රතිපත්ති සංසන්ධන'],
        ['id' => 'australia-explained', 'label' => 'Australia explained', 'label_si' => 'ඕස්ට්‍රේලියාව පැහැදිලි කිරීම'],
        ['id' => 'about', 'label' => 'About', 'label_si' => 'About'],
    ];
}

function aswproject_render_lang_switcher(): void
{
    ?>
    <div class="amd-lang-switch" role="group" aria-label="Language">
      <button type="button" class="amd-lang-switch__btn" data-lang-switch="en" aria-pressed="false">EN</button>
      <button type="button" class="amd-lang-switch__btn" data-lang-switch="si" aria-pressed="false">සිං</button>
    </div>
<?php
}

function aswproject_render_site_header(string $currentPage = ''): void
{
    $site = aswproject_load_site_config();
    $siteTitle = trim((string) ($site['site_title'] ?? 'A Migrant\'s Diary'));
    $siteSubtitle = trim((string) ($site['site_subtitle'] ?? 'සිංහල ඔසියා'));
    $homeHref = aswproject_page_href('home');
    ?>
    <header class="amd-header">
      <div class="amd-header__top">
        <div class="amd-header__brand-wrap">
          <a class="amd-header__brand-link" href="<?= aswproject_escape($homeHref) ?>">
            <span class="amd-header__brand" lang="en"><?= aswproject_escape($siteTitle) ?></span>
            <span class="amd-header__subtitle" lang="si"><?= aswproject_escape($siteSubtitle) ?></span>
          </a>
        </div>
        <div class="amd-header__actions">
          <?php aswproject_render_lang_switcher(); ?>
          <?php aswproject_render_social_links('amd-header__social'); ?>
        </div>
      </div>
      <nav class="amd-nav" aria-label="Main navigation">
        <ul class="amd-nav__list">
<?php foreach (aswproject_nav_items() as $item): ?>
<?php
    $isCurrent = $currentPage === $item['id'];
    $href = aswproject_page_href($item['id']);
    $classes = 'amd-nav__link' . ($isCurrent ? ' amd-nav__link--current' : '');
?>
          <li class="amd-nav__item">
            <a class="<?= aswproject_escape($classes) ?>" href="<?= aswproject_escape($href) ?>"<?= $isCurrent ? ' aria-current="page"' : '' ?>>
              <span class="amd-nav__label" lang="en"><?= aswproject_escape($item['label']) ?></span>
              <span class="amd-nav__label" lang="si"><?= aswproject_escape($item['label_si']) ?></span>
            </a>
          </li>
<?php endforeach; ?>
        </ul>
      </nav>
    </header>
<?php
}

function aswproject_render_site_footer(): void
{
    $site = aswproject_load_site_config();
    $siteTitle = trim((string) ($site['site_title'] ?? 'A Migrant\'s Diary'));
    $year = date('Y');
    ?>
    <footer class="amd-footer">
      <div class="amd-footer__inner">
        <?php aswproject_render_social_links('amd-footer__social'); ?>
        <p class="amd-footer__copy" lang="en">&copy; <?= aswproject_escape($year) ?> <?= aswproject_escape($siteTitle) ?>. Independent editorial — not affiliated with any political party.</p>
        <p class="amd-footer__copy" lang="si">&copy; <?= aswproject_escape($year) ?> <?= aswproject_escape($siteTitle) ?>. ස්වාධීන editorial — කිසිදු political party එකකට affiliated නොවේ.</p>
      </div>
    </footer>
<?php
}

/**
 * @param array<string, mixed> $hero
 */
function aswproject_render_hero(array $hero): void
{
    $eyebrow = trim((string) ($hero['eyebrow'] ?? ''));
    $title = trim((string) ($hero['title'] ?? ''));
    $titleSi = trim((string) ($hero['title_si'] ?? ''));
    $lead = trim((string) ($hero['lead'] ?? ''));
    $leadSi = trim((string) ($hero['lead_si'] ?? ''));
    ?>
    <section class="amd-hero">
<?php if ($eyebrow !== ''): ?>
      <p class="amd-hero__eyebrow"><?= aswproject_escape($eyebrow) ?></p>
<?php endif; ?>
<?php if ($title !== ''): ?>
      <h1 class="amd-hero__title" lang="en"><?= aswproject_escape($title) ?></h1>
<?php endif; ?>
<?php if ($titleSi !== ''): ?>
      <p class="amd-hero__title-si" lang="si"><?= aswproject_escape($titleSi) ?></p>
<?php endif; ?>
<?php if ($lead !== ''): ?>
      <p class="amd-hero__lead" lang="en"><?= aswproject_escape($lead) ?></p>
<?php endif; ?>
<?php if ($leadSi !== ''): ?>
      <p class="amd-hero__lead-si" lang="si"><?= aswproject_escape($leadSi) ?></p>
<?php endif; ?>
    </section>
<?php
}

/**
 * @param array<string, mixed> $data
 */
function aswproject_render_my_thoughts(array $data): void
{
    $title = trim((string) ($data['title'] ?? 'My thoughts'));
    $titleSi = trim((string) ($data['title_si'] ?? ''));
    $body = trim((string) ($data['body'] ?? ''));
    $bodySi = trim((string) ($data['body_si'] ?? ''));

    if ($body === '' && $bodySi === '') {
        return;
    }
    ?>
    <aside class="amd-thoughts" aria-label="My thoughts">
      <p class="amd-thoughts__label" lang="en"><?= aswproject_escape($title) ?></p>
<?php if ($titleSi !== ''): ?>
      <p class="amd-thoughts__label" lang="si"><?= aswproject_escape($titleSi) ?></p>
<?php endif; ?>
<?php if ($body !== ''): ?>
      <p class="amd-thoughts__body" lang="en"><?= aswproject_escape($body) ?></p>
<?php endif; ?>
<?php if ($bodySi !== ''): ?>
      <p class="amd-thoughts__body amd-thoughts__body--si" lang="si"><?= aswproject_escape($bodySi) ?></p>
<?php endif; ?>
    </aside>
<?php
}

/**
 * @param list<array<string, mixed>> $sources
 */
function aswproject_render_source_list(array $sources, string $title = 'Sources and references', string $titleSi = 'මූලාශ්‍ර'): void
{
    if ($sources === []) {
        return;
    }
    ?>
    <section class="amd-sources">
      <h2 class="amd-section-title" lang="en"><?= aswproject_escape($title) ?></h2>
      <h2 class="amd-section-title amd-section-title--si" lang="si"><?= aswproject_escape($titleSi) ?></h2>
      <ul class="amd-sources__list">
<?php foreach ($sources as $source): ?>
<?php
    if (!is_array($source)) {
        continue;
    }
    $label = trim((string) ($source['label'] ?? ''));
    $url = trim((string) ($source['url'] ?? ''));
    if ($label === '' || $url === '') {
        continue;
    }
?>
        <li><a href="<?= aswproject_escape($url) ?>" rel="noopener noreferrer" target="_blank"><?= aswproject_escape($label) ?></a></li>
<?php endforeach; ?>
      </ul>
    </section>
<?php
}

function aswproject_render_social_links(string $wrapperClass = 'amd-social'): void
{
    $site = aswproject_load_site_config();
    $facebookUrl = trim((string) ($site['facebook_page_url'] ?? ''));

    if ($facebookUrl === '') {
        return;
    }
    ?>
    <div class="<?= aswproject_escape($wrapperClass) ?>">
      <a class="amd-social__link" href="<?= aswproject_escape($facebookUrl) ?>" rel="noopener noreferrer" target="_blank">
        <span class="amd-social__icon" aria-hidden="true">f</span>
        <span>Facebook</span>
      </a>
    </div>
<?php
}

function aswproject_format_article_date(string $date): string
{
    $date = trim($date);
    if ($date === '') {
        return '';
    }

    $parsed = DateTimeImmutable::createFromFormat('Y-m-d', $date);
    if ($parsed instanceof DateTimeImmutable) {
        return $parsed->format('j M Y');
    }

    return $date;
}

/**
 * @param list<array<string, mixed>> $articles
 * @return list<array<string, mixed>>
 */
function aswproject_filter_published_articles(array $articles): array
{
    $published = [];

    foreach ($articles as $article) {
        if (!is_array($article)) {
            continue;
        }
        $status = trim((string) ($article['status'] ?? 'published'));
        if ($status === 'coming_soon') {
            continue;
        }
        $published[] = $article;
    }

    return $published;
}

function aswproject_render_articles_index_heading(): void
{
    ?>
    <header class="amd-articles-index">
      <p class="amd-articles-index__eyebrow" lang="en">News &amp; reads</p>
      <p class="amd-articles-index__eyebrow" lang="si">පුවත් &amp; ලිපi</p>
      <h1 class="amd-articles-index__title" lang="en">Articles</h1>
      <h1 class="amd-articles-index__title amd-articles-index__title--si" lang="si">ලිපi</h1>
    </header>
<?php
}

/**
 * @param list<array<string, mixed>> $articles
 */
function aswproject_render_news_cards(array $articles): void
{
    $articles = aswproject_filter_published_articles($articles);

    if ($articles === []) {
        echo '<p class="amd-empty" lang="en">No articles yet.</p>';
        echo '<p class="amd-empty" lang="si">තවම ලිපi නැත.</p>';
        return;
    }
    ?>
    <div class="amd-news-grid">
<?php foreach ($articles as $article): ?>
<?php
    if (!is_array($article)) {
        continue;
    }
    $title = trim((string) ($article['title'] ?? ''));
    $titleSi = trim((string) ($article['title_si'] ?? ''));
    $excerpt = trim((string) ($article['excerpt'] ?? ''));
    $excerptSi = trim((string) ($article['excerpt_si'] ?? ''));
    $dateRaw = trim((string) ($article['date'] ?? ''));
    $dateDisplay = aswproject_format_article_date($dateRaw);
    $hrefKey = trim((string) ($article['href'] ?? ''));
    $href = aswproject_resolve_content_href($hrefKey);
    $tag = trim((string) ($article['tag'] ?? 'Article'));
    $image = trim((string) ($article['image'] ?? ''));
?>
      <a class="amd-news-card" href="<?= aswproject_escape($href) ?>">
<?php if ($image !== ''): ?>
        <div class="amd-news-card__media">
          <img class="amd-news-card__img" src="<?= aswproject_escape($image) ?>" alt="" loading="lazy" decoding="async">
        </div>
<?php else: ?>
        <div class="amd-news-card__media amd-news-card__media--placeholder" aria-hidden="true">
          <span class="amd-news-card__mark">A Migrant's Diary</span>
        </div>
<?php endif; ?>
        <div class="amd-news-card__body">
          <div class="amd-news-card__meta">
<?php if ($dateDisplay !== ''): ?>
            <time class="amd-news-card__date" datetime="<?= aswproject_escape($dateRaw) ?>"><?= aswproject_escape($dateDisplay) ?></time>
<?php endif; ?>
            <span class="amd-news-card__tag" lang="en"><?= aswproject_escape($tag) ?></span>
          </div>
          <h2 class="amd-news-card__title" lang="en"><?= aswproject_escape($title) ?></h2>
<?php if ($titleSi !== ''): ?>
          <p class="amd-news-card__title-si" lang="si"><?= aswproject_escape($titleSi) ?></p>
<?php endif; ?>
<?php if ($excerpt !== ''): ?>
          <p class="amd-news-card__excerpt" lang="en"><?= aswproject_escape($excerpt) ?></p>
<?php endif; ?>
<?php if ($excerptSi !== ''): ?>
          <p class="amd-news-card__excerpt amd-news-card__excerpt--si" lang="si"><?= aswproject_escape($excerptSi) ?></p>
<?php endif; ?>
          <span class="amd-news-card__cta"><span lang="en">Read article</span><span lang="si">ලිපi කියවන්න</span></span>
        </div>
      </a>
<?php endforeach; ?>
    </div>
<?php
}

/**
 * @param list<array<string, mixed>> $articles
 */
function aswproject_render_article_cards(array $articles): void
{
    aswproject_render_news_cards($articles);
}

/**
 * @param list<array<string, mixed>> $links
 */
function aswproject_render_policy_cards(array $links): void
{
    if ($links === []) {
        return;
    }
    ?>
    <div class="amd-card-grid amd-card-grid--policy">
<?php foreach ($links as $link): ?>
<?php
    if (!is_array($link)) {
        continue;
    }
    $label = trim((string) ($link['label'] ?? ''));
    $labelSi = trim((string) ($link['label_si'] ?? ''));
    $hrefKey = trim((string) ($link['href'] ?? ''));
    $type = trim((string) ($link['type'] ?? 'policy'));
    $href = $hrefKey !== '' ? aswproject_page_href($hrefKey) : '#';
?>
      <a class="amd-policy-card amd-policy-card--<?= aswproject_escape($type) ?>" href="<?= aswproject_escape($href) ?>">
        <span class="amd-policy-card__icon" aria-hidden="true"></span>
        <span class="amd-policy-card__label" lang="en"><?= aswproject_escape($label) ?></span>
<?php if ($labelSi !== ''): ?>
        <span class="amd-policy-card__label-si" lang="si"><?= aswproject_escape($labelSi) ?></span>
<?php endif; ?>
      </a>
<?php endforeach; ?>
    </div>
<?php
}

/**
 * @param list<array<string, mixed>> $items
 */
function aswproject_render_topic_grid(array $items, string $title = '', string $titleSi = ''): void
{
    ?>
    <section class="amd-topics">
<?php if ($title !== ''): ?>
      <h2 class="amd-section-title" lang="en"><?= aswproject_escape($title) ?></h2>
<?php endif; ?>
<?php if ($titleSi !== ''): ?>
      <p class="amd-section-title-si" lang="si"><?= aswproject_escape($titleSi) ?></p>
<?php endif; ?>
      <div class="amd-topic-grid">
<?php foreach ($items as $item): ?>
<?php
    if (!is_array($item)) {
        continue;
    }
    $icon = trim((string) ($item['icon'] ?? 'default'));
    $itemTitle = trim((string) ($item['title'] ?? ''));
    $itemTitleSi = trim((string) ($item['title_si'] ?? ''));
    $text = trim((string) ($item['text'] ?? ''));
    $textSi = trim((string) ($item['text_si'] ?? ''));
?>
        <article class="amd-topic-card amd-topic-card--<?= aswproject_escape($icon) ?>">
          <h3 class="amd-topic-card__title" lang="en"><?= aswproject_escape($itemTitle) ?></h3>
<?php if ($itemTitleSi !== ''): ?>
          <p class="amd-topic-card__title-si" lang="si"><?= aswproject_escape($itemTitleSi) ?></p>
<?php endif; ?>
<?php if ($text !== ''): ?>
          <p class="amd-topic-card__text" lang="en"><?= aswproject_escape($text) ?></p>
<?php endif; ?>
<?php if ($textSi !== ''): ?>
          <p class="amd-topic-card__text amd-topic-card__text--si" lang="si"><?= aswproject_escape($textSi) ?></p>
<?php endif; ?>
        </article>
<?php endforeach; ?>
      </div>
    </section>
<?php
}

/**
 * @param array<string, mixed> $section
 */
function aswproject_render_text_section(array $section): void
{
    $title = trim((string) ($section['title'] ?? ''));
    $titleSi = trim((string) ($section['title_si'] ?? ''));
    $body = trim((string) ($section['body'] ?? ''));
    $bodySi = trim((string) ($section['body_si'] ?? ''));
    ?>
    <section class="amd-text-section">
<?php if ($title !== ''): ?>
      <h2 class="amd-section-title" lang="en"><?= aswproject_escape($title) ?></h2>
<?php endif; ?>
<?php if ($titleSi !== ''): ?>
      <p class="amd-section-title-si" lang="si"><?= aswproject_escape($titleSi) ?></p>
<?php endif; ?>
<?php if ($body !== ''): ?>
      <p class="amd-text-section__body" lang="en"><?= aswproject_escape($body) ?></p>
<?php endif; ?>
<?php if ($bodySi !== ''): ?>
      <p class="amd-text-section__body amd-text-section__body--si" lang="si"><?= aswproject_escape($bodySi) ?></p>
<?php endif; ?>
    </section>
<?php
}

/**
 * @param array<string, mixed> $content
 */
function aswproject_render_policy_comparison(array $content): void
{
    $pageTitle = trim((string) ($content['page_title'] ?? 'Content'));
    $intro = trim((string) ($content['intro'] ?? ''));
    $columns = $content['columns'] ?? [];
    $rows = $content['rows'] ?? [];

    if (!is_array($columns) || !is_array($rows)) {
        echo '<section class="amd-card"><p class="amd-empty">Table configuration is invalid.</p></section>';
        return;
    }

    $partyColumns = [];
    foreach ($columns as $column) {
        if (!is_array($column)) {
            continue;
        }
        $key = trim((string) ($column['key'] ?? ''));
        if ($key !== '' && $key !== 'policy_area') {
            $partyColumns[] = $column;
        }
    }
    ?>
    <section class="amd-card">
      <h2 class="amd-card__title" lang="en"><?= aswproject_escape($pageTitle) ?></h2>
      <h2 class="amd-card__title amd-card__title--si" lang="si">වත්මන් ප්‍රතිපත්ති සංසන්ධනය</h2>
<?php if ($intro !== ''): ?>
      <p class="amd-card__intro" lang="en"><?= aswproject_escape($intro) ?></p>
      <p class="amd-card__intro" lang="si">ප්‍රධාන පක්ෂවල සංක්‍රමණ ප්‍රතිපත්ති side-by-side සංසන්ධනය.</p>
<?php endif; ?>
<?php if ($columns === []): ?>
      <p class="amd-empty">No table columns configured.</p>
<?php elseif ($rows === []): ?>
      <p class="amd-empty">No table rows configured yet.</p>
<?php else: ?>
      <div class="amd-table-wrap amd-table-wrap--desktop">
        <table class="amd-table amd-table--compare">
          <thead>
            <tr>
<?php foreach ($columns as $column): ?>
<?php
    if (!is_array($column)) {
        continue;
    }
    $label = trim((string) ($column['label'] ?? ''));
?>
              <th scope="col"><?php aswproject_render_cell_text($label); ?></th>
<?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
<?php foreach ($rows as $row): ?>
<?php
    if (!is_array($row)) {
        continue;
    }
?>
            <tr>
<?php foreach ($columns as $column): ?>
<?php
    if (!is_array($column)) {
        continue;
    }
    $key = trim((string) ($column['key'] ?? ''));
    $type = trim((string) ($column['type'] ?? 'text'));
    $cell = $row[$key] ?? '';
?>
              <td>
<?php if ($type === 'link' && is_string($cell) && $cell !== ''): ?>
                <a href="<?= aswproject_escape($cell) ?>" rel="noopener noreferrer" target="_blank">Open</a>
<?php else: ?>
                <?php aswproject_render_cell_text($cell); ?>
<?php endif; ?>
              </td>
<?php endforeach; ?>
            </tr>
<?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="amd-policy-stack" aria-label="Policy comparison by topic">
<?php foreach ($rows as $row): ?>
<?php
    if (!is_array($row)) {
        continue;
    }
    $topic = $row['policy_area'] ?? '';
?>
        <article class="amd-policy-stack__item">
          <h3 class="amd-policy-stack__topic"><?php aswproject_render_cell_text($topic); ?></h3>
          <div class="amd-policy-stack__parties">
<?php foreach ($partyColumns as $column): ?>
<?php
    $key = trim((string) ($column['key'] ?? ''));
    $label = trim((string) ($column['label'] ?? ''));
    $cell = $row[$key] ?? '';
?>
            <div class="amd-policy-stack__party">
              <h4 class="amd-policy-stack__party-name"><?php aswproject_render_cell_text($label); ?></h4>
              <div class="amd-policy-stack__party-body"><?php aswproject_render_cell_text($cell); ?></div>
            </div>
<?php endforeach; ?>
          </div>
        </article>
<?php endforeach; ?>
      </div>
<?php endif; ?>
    </section>
<?php
}

/**
 * @param array<string, mixed> $content
 * @deprecated Use aswproject_render_policy_comparison()
 */
function aswproject_render_content_table(array $content): void
{
    aswproject_render_policy_comparison($content);
}

/**
 * @param array<string, mixed>|null $image
 */
function aswproject_render_article_figure(?array $image): void
{
    if (!is_array($image)) {
        return;
    }

    $src = trim((string) ($image['src'] ?? ''));
    $alt = trim((string) ($image['alt'] ?? ''));
    $caption = trim((string) ($image['caption'] ?? ''));

    if ($src === '') {
        return;
    }

    if ($alt === '') {
        $alt = 'Article illustration';
    }
    ?>
    <figure class="amd-article-figure">
      <img class="amd-article-figure__img" src="<?= aswproject_escape($src) ?>" alt="<?= aswproject_escape($alt) ?>" loading="lazy" decoding="async">
<?php if ($caption !== ''): ?>
      <figcaption class="amd-article-figure__caption"><?= aswproject_escape($caption) ?></figcaption>
<?php endif; ?>
    </figure>
<?php
}

/**
 * @param array<string, mixed> $article
 */
function aswproject_render_full_article(array $article): void
{
    $pageTitle = trim((string) ($article['page_title'] ?? ''));
    $headline = trim((string) ($article['headline'] ?? $pageTitle));
    $eyebrow = trim((string) ($article['eyebrow'] ?? 'Article'));
    $published = trim((string) ($article['published'] ?? ''));
    $paragraphs = $article['paragraphs'] ?? [];
    $images = $article['images'] ?? [];
    $heroImage = $article['hero_image'] ?? null;

    if (!is_array($paragraphs)) {
        $paragraphs = [];
    }

    $imagesByParagraph = [];
    if (is_array($images)) {
        foreach ($images as $image) {
            if (!is_array($image)) {
                continue;
            }
            $index = (int) ($image['after_paragraph'] ?? -1);
            if ($index < 0) {
                continue;
            }
            if (!isset($imagesByParagraph[$index])) {
                $imagesByParagraph[$index] = [];
            }
            $imagesByParagraph[$index][] = $image;
        }
    }
    ?>
    <article class="amd-article">
      <header class="amd-article__header">
<?php if ($eyebrow !== ''): ?>
        <p class="amd-article__eyebrow"><?= aswproject_escape($eyebrow) ?></p>
<?php endif; ?>
        <h1 class="amd-article__title" lang="en"><?= aswproject_escape($headline) ?></h1>
<?php if ($pageTitle !== '' && $pageTitle !== $headline): ?>
        <p class="amd-article__subtitle" lang="en"><?= aswproject_escape($pageTitle) ?></p>
<?php endif; ?>
<?php if ($published !== ''): ?>
        <p class="amd-article__meta"><time datetime="<?= aswproject_escape($published) ?>"><?= aswproject_escape($published) ?></time></p>
<?php endif; ?>
      </header>
<?php
    if (is_array($heroImage)) {
        aswproject_render_article_figure($heroImage);
    }
?>
      <div class="amd-article__body" lang="en">
<?php
    foreach ($paragraphs as $index => $block) {
        if (!is_array($block)) {
            $text = trim(is_scalar($block) ? (string) $block : '');
            if ($text === '') {
                continue;
            }
            echo '<p class="amd-article__p">' . aswproject_escape($text) . '</p>';
        } else {
            $text = trim((string) ($block['text'] ?? ''));
            if ($text === '') {
                continue;
            }
            $style = trim((string) ($block['style'] ?? ''));
            $class = 'amd-article__p';
            if ($style === 'standout') {
                $class .= ' amd-article__p--standout';
            } elseif ($style === 'closing') {
                $class .= ' amd-article__p--closing';
            }
            echo '<p class="' . aswproject_escape($class) . '">' . aswproject_escape($text) . '</p>';
        }

        if (isset($imagesByParagraph[$index]) && is_array($imagesByParagraph[$index])) {
            foreach ($imagesByParagraph[$index] as $image) {
                if (is_array($image)) {
                    aswproject_render_article_figure($image);
                }
            }
        }
    }
?>
      </div>
      <p class="amd-article__back">
        <a class="amd-text-link" href="<?= aswproject_escape(aswproject_page_href('articles')) ?>"><span lang="en">← All articles</span><span lang="si">← සියලු ලිපi</span></a>
      </p>
    </article>
<?php
}
