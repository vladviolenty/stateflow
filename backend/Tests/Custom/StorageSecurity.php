<?php

namespace Flow\Tests\Custom;

use VladViolentiy\VivaFramework\Exceptions\ValidationException;
use Flow\Id\Storage\Storage;
use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\ParserFactory;

class StorageSecurity
{
    /**
     * @var class-string[]
     */
    private array $storageTestList = [
        Storage::class
    ];

    public function storageQueryTest(): void
    {
        $parse = (new ParserFactory())->createForNewestSupportedVersion();

        $traverser = new NodeTraverser();
        $traverser->addVisitor(new class () extends NodeVisitorAbstract {
            public function leaveNode(Node $node): ?int
            {

                if ($node instanceof Node\Expr\MethodCall) {
                    /** @var Node\Identifier $name */
                    $name = $node->name;
                    if(($name->toString() === "executeQueryBool" or $name->toString() === "executeQuery")) {
                        if(count($node->args) !== 3) {
                            echo "Execute query bool need 3 params. Exit";
                            exit(1);
                        }
                        /** @var Node\Scalar\String_ $query */
                        $query = $node->getArgs()[0]->value;
                        /** @var Node\Scalar\String_ $types */
                        $types = $node->getArgs()[1]->value;
                        /** @var Node\Expr\Array_ $params */
                        $params = $node->getArgs()[2]->value;
                        $questionMarkCount = substr_count($query->value, "?");
                        $paramsCount = strlen($types->value);
                        $arrayParamsCount = count($params->items);
                        if($questionMarkCount !== $paramsCount or $questionMarkCount !== $arrayParamsCount) {
                            /** @var int $line */
                            $line = $node->getAttribute("endLine");
                            throw new ValidationException((string)$line);

                        }
                    }

                }
                return null;

            }
        });

        foreach ($this->storageTestList as $item) {
            $reflection = new \ReflectionClass($item);
            $fileName = $reflection->getFileName();
            if($fileName === false) {
                echo "Ошибка. Класс $item не найден";
                exit(255);
            }
            /** @var string $fileContent */
            $fileContent = file_get_contents($fileName);
            /** @var Node\Stmt[] $ast */
            $ast = $parse->parse($fileContent);
            try {
                $traverser->traverse($ast);
            } catch (ValidationException $validationException) {
                echo "Ошибка в классе $item, строка ".$validationException->getMessage();
                exit(255);
            }
        }
    }
}
