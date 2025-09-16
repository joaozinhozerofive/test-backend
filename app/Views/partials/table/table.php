<?php if (empty($data)): ?>
    <div class="table-container">
        <div class="empty-state">
            <h3>📭 Nenhum registro encontrado</h3>
            <p>Não há dados para exibir no momento.</p>
        </div>
    </div>
<?php else: ?>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <?php foreach ($columns as $key => $column): ?>
                        <th class="<?= $column['sortable'] ? 'sortable' : '' ?>">
                            <?= htmlspecialchars($column['label']) ?>
                        </th>
                    <?php endforeach; ?>
                    <?php if (!empty($actions)): ?>
                        <th>Ações</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($paginatedData as $item): ?>
                    <tr>
                        <?php foreach ($columns as $key => $column): ?>
                            <td><?= htmlspecialchars($item[$key] ?? '') ?></td>
                        <?php endforeach; ?>
                        <?php if (!empty($actions)): ?>
                            <td class="actions-cell">
                                <?php foreach ($actions as $actionKey => $action): ?>
                                    <?php 
                                    $url = str_replace('{id}', $item['id'] ?? '', $action['url']);
                                    $label = htmlspecialchars($action['label']);
                                    $class = $action['options']['class'] ?? 'btn-primary';
                                    $icon = $action['options']['icon'] ?? '';
                                    ?>
                                    <?php if ($actionKey === 'delete'): ?>
                                        <?php 
                                        $itemName = '';
                                        if (isset($item['name'])) {
                                            $itemName = htmlspecialchars($item['name']);
                                        } elseif (isset($item['person_name']) && isset($item['description'])) {
                                            $itemName = htmlspecialchars($item['person_name']) . ' - ' . htmlspecialchars($item['description']);
                                        } elseif (isset($item['description'])) {
                                            $itemName = htmlspecialchars($item['description']);
                                        } else {
                                            $itemName = 'este item';
                                        }
                                        ?>
                                        <button onclick="openDeleteModal('<?= htmlspecialchars($url) ?>', '<?= $itemName ?>')" 
                                                class="btn btn-sm <?= htmlspecialchars($class) ?>">
                                            <?= $icon ?> <?= $label ?>
                                        </button>
                                    <?php else: ?>
                                        <a href="<?= htmlspecialchars($url) ?>" class="btn btn-sm <?= htmlspecialchars($class) ?>">
                                            <?= $icon ?> <?= $label ?>
                                        </a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if ($totalPages > 1): ?>
            <?php 
                $basePath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                $params = $_GET ?? [];
                unset($params['page']);
                $buildUrl = function($page) use ($basePath, $params) {
                    $query = http_build_query(array_merge($params, ['page' => $page]));
                    return htmlspecialchars($basePath . '?' . $query);
                };
            ?>
            <div class="pagination">
                <?php if ($currentPage > 1): ?>
                    <a href="<?= $buildUrl($currentPage - 1) ?>">← Anterior</a>
                <?php endif; ?>
                
                <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                    <?php if ($page == $currentPage): ?>
                        <span class="current"><?= $page ?></span>
                    <?php else: ?>
                        <a href="<?= $buildUrl($page) ?>"><?= $page ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
                
                <?php if ($currentPage < $totalPages): ?>
                    <a href="<?= $buildUrl($currentPage + 1) ?>">Próximo →</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>
