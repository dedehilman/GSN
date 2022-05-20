@extends('layout', ['title' => Lang::get("Node"), 'subTitle' => Lang::get("Manage data node")])

@section('style')
    <link rel="stylesheet" href="{{ asset('public/plugins/flowchart/css/jquery.flowchart.min.css') }}">
    <style>
        #flowchartworkspace {
            width: 2000px;
            height: 2000px;
        }
        #flowchartContainer {       
            position: relative;
            overflow: auto;
            width: 100%; 
            height: 100%;
            font-size: 10px;
        }
        .flowchart-operator {
            width: 80px !important;
            border-radius: 6px;
        }
        .flowchart-operator .flowchart-operator-title {
            border-top-left-radius: 6px;
            border-top-right-radius: 6px;
        }
        .flowchart-operator-connector-label {
            height: 8px;
        }
        .flowchart-operator.selected {
            border-color: #999;
        }
        .flowchart-operator.selected .flowchart-operator-title{
            background: #007bff;
            color: white;
        }
        img.node-type {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <form action="{{route('route.node.store', ['parentId' => $data->id])}}" method="POST">
        <input type="hidden" name="route_id" value="{{$data->id}}">
        <div id="additionalInput">
        </div>
        {{-- <button type="button" class="btn btn-primary" id="btn-save-custom">Save</button> --}}
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('Workspace')}}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="height: 385px;">  
                        <div id="flowchartContainer">
                            <div id="flowchartworkspace">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('Node Type')}}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">  
                        <img class="node-type mb-2" src="{{ asset('public/img/workflow/start.png') }}" width="35" height="35" data-nb-inputs="0" data-nb-outputs="1" title="{{__('Start')}}" data-nb-type="START" />
                        <img class="node-type mb-2" src="{{ asset('public/img/workflow/applicant.png') }}" width="35" height="35" data-nb-inputs="1" data-nb-outputs="1" title="{{__('Applicant')}}" data-nb-type="APPLICANT" />
                        <img class="node-type mb-2" src="{{ asset('public/img/workflow/approver.png') }}" width="35" height="35" data-nb-inputs="1" data-nb-outputs="1" title="{{__('Approver')}}" data-nb-type="APPROVER" />
                        <img class="node-type mb-2" src="{{ asset('public/img/workflow/notification.png') }}" width="35" height="35" data-nb-inputs="1" data-nb-outputs="1" title="{{__('Notification')}}" data-nb-type="NOTIFICATION" />
                        <img class="node-type mb-2" src="{{ asset('public/img/workflow/start-branch.png') }}" width="35" height="35" data-nb-inputs="1" data-nb-outputs="2" title="{{__('Start Branch')}}" data-nb-type="START_BRANCH" />
                        <img class="node-type mb-2" src="{{ asset('public/img/workflow/end-branch.png') }}" width="35" height="35" data-nb-inputs="2" data-nb-outputs="1" title="{{__('End Branch')}}" data-nb-type="END_BRANCH" />
                        <img class="node-type mb-2" src="{{ asset('public/img/workflow/end.png') }}" width="35" height="35" data-nb-inputs="1" data-nb-outputs="0" title="{{__('End')}}" data-nb-type="END" />
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-danger" id="btn-delete-node" disabled><i class="fas fa-trash"></i> {{__("Delete")}}</button>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__('Node Properties')}}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">  
                        <div class="node-property">
                            <div class="form-group">
                                <label class="mb-0">{{__('Node Type')}}</label>
                                <p class="node-type"></p>
                            </div>
                            <div class="form-group">
                                <label class="mb-0">{{__('Node Owner Type')}}</label>
                                <select class="custom-select node-owner-type d-none" name="owner_type">
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="mb-0">{{__('Node Owner')}}</label>
                                <span style="cursor: pointer;" class="d-block node-owner text-primary show-modal-select-custom" data-title="" data-url="" data-handler="onOwnerSelected"></span>
                            </div>
                            <div class="form-group">
                                <label class="mb-0">{{__('Notification Template')}}</label>
                                <span style="cursor: pointer;" class="d-block node-notification text-primary show-modal-select" data-title="{{__('Notification Template List')}}" data-url="{{route('notification-template.select', 'select=multiple')}}" data-handler="onNotificationSelected"></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-default" id="btn-cancel-property" disabled><i class="fas fa-undo"></i> {{__("Cancel")}}</button>
                        <button class="btn btn-primary" id="btn-save-property" disabled><i class="fas fa-save"></i> {{__("Save")}}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script src="{{ asset('public/plugins/flowchart/js/jquery.flowchart.js') }}"></script>
    
    <script>
        var notificationIds = [], ownerIds = [], flowchart;
        $(function() {
            
            flowchart = $('#flowchartworkspace');
            flowchart.flowchart({
                data: prepareData(),
                defaultLinkColor: "grey",
                defaultSelectedLinkColor: "#007bff",
                linkWidth: '2',
                grid: 10,
                canUserEditLinks: true,
                canUserMoveOperators: true,
                multipleLinksOnInput: false,
                multipleLinksOnOutput: false,
            });
            setHeaderColor();
            
            flowchart.flowchart({
                onOperatorSelect: function(operatorId) {
                    dataSelected = flowchart.flowchart('getOperatorData', operatorId);
                    var type = dataSelected['properties']['type'];
                    var ownerType = dataSelected['properties']['owner_type'];
                    ownerIds = dataSelected['properties']['owner_id'];
                    notificationIds = dataSelected['properties']['notification_id'];
                    operatorIdSelected = operatorId;
                    
                    $('.node-property .node-owner-type').empty().removeClass('d-none');
                    if(type == "APPLICANT" || type == "APPROVER" || type == "NOTIFICATION") {
                        $(".node-property .node-owner-type").append(new Option("All", "ALL"));
                        $(".node-property .node-owner-type").append(new Option("Employee", "EMPLOYEE"));
                        $(".node-property .node-owner-type").append(new Option("Position", "POSITION"));

                        if (type == "APPROVER" || type == "NOTIFICATION") {
                            $(".node-property .node-owner-type").append(new Option("Position Organization Of Applicant", "POSITION_ORGANIZATION_OF_APPLICANT"));
                            $(".node-property .node-owner-type").append(new Option("Applicant", "APPLICANT"));
                        }
                        
                        $('.node-property .node-owner-type').attr('disabled', false);
                    } else {
                        $(".node-property .node-owner-type").append(new Option("Rule", "RULE"));
                        $('.node-property .node-owner-type').attr('disabled', true);
                    }
                    
                    $('.node-property .node-type').html(type);
                    $('.node-property .node-owner-type').val(ownerType).trigger('change');
                    $('#btn-cancel-property').attr('disabled', false);
                    $('#btn-save-property').attr('disabled', false);
                    $('#btn-delete-node').attr('disabled', false);
                    return true;
                },
                onOperatorUnselect: function() {
                    $('.node-property .node-type').html("");
                    $('.node-property .node-owner-type').val("").attr('disabled', true).addClass('d-none');
                    setHeaderColor();
                    $('#btn-cancel-property').attr('disabled', true);
                    $('#btn-save-property').attr('disabled', true);
                    $('#btn-delete-node').attr('disabled', true);
                    $('.node-property .node-owner').html("");
                    $('.node-property .node-notification').html("");
                    return true;
                },
                onLinkSelect: function(linkId) {
                    $('#btn-delete-node').attr('disabled', false);
                    return true;
                },
                onLinkUnselect: function() {
                    $('#btn-delete-node').attr('disabled', true);
                    return true;
                },
                onLinkCreate: function(data1, data2) {
                    return true;
                }
            });

            var operatorI = 0;
            $(".node-type").click(function() {
                var operatorId = "new_" + operatorI + makeId(10);
                var operatorData = getOperatorData($(this));
                operatorData.left = ((flowchart.width() / 5) - 100 + (operatorI * 10));
                operatorData.top = ((flowchart.height() / 10) - 30);

                operatorI++;

                flowchart.flowchart('createOperator', operatorId, operatorData);
                setHeaderColor();
            });

            $('#btn-cancel-property').on('click', function(){
                $('.node-property .node-type').html("");
                $('.node-property .node-owner-type').val("").attr('disabled', true).addClass('d-none');
                setHeaderColor();

                $('#btn-cancel-property').attr('disabled', true);
                $('#btn-save-property').attr('disabled', true);
                $('#btn-delete-node').attr('disabled', true);
                $('.node-property .node-owner').html("");
                $('.node-property .node-notification').html("");
            });

            $('#btn-save-property').on('click', function(){
                dataSelected['properties']['owner_type'] = $("select[name='owner_type']").val();
                dataSelected['properties']['notification_id'] = notificationIds
                dataSelected['properties']['owner_id'] = ownerIds
                flowchart.flowchart('setOperatorData', operatorIdSelected, dataSelected);

                $('.node-property .node-type').html("");
                $('.node-property .node-owner-type').val("").attr('disabled', true).addClass('d-none');
                setHeaderColor();
                $('#btn-cancel-property').attr('disabled', true);
                $('#btn-save-property').attr('disabled', true);
                $('#btn-delete-node').attr('disabled', true);
                $('.node-property .node-owner').html("");
                $('.node-property .node-notification').html("");
            });

            $('#btn-delete-node').on('click', function(){
                flowchart.flowchart('deleteSelected');
            });

            $(".node-property .node-owner-type").change(function() {
                var type = dataSelected['properties']['type'];
                
                // ownerIds = [];
                if($(this).val() == "ALL" || $(this).val() == "APPLICANT" || type == "START" || type == "END" || type == "END_BRANCH") {
                    $('.node-property .node-owner').html("");
                } else {
                    $('.node-property .node-owner').html(ownerIds.length + " Node Owner");
                }
                if(type == "START" || type == "END" || type == "START_BRANCH" || type == "END_BRANCH") {
                    $('.node-property .node-notification').html("");
                } else {
                    $('.node-property .node-notification').html(notificationIds.length + " Notification");
                }

                if($(this).val() == "EMPLOYEE") {
                    $(".node-property .node-owner").attr("data-url", "{{route('employee.select', 'select=multiple')}}");
                    $(".node-property .node-owner").attr("data-title", "{{__('Employee List')}}");
                } else if($(this).val() == "RULE") {
                    $(".node-property .node-owner").attr("data-url", "{{route('rule.select', 'select=multiple')}}");
                    $(".node-property .node-owner").attr("data-title", "{{__('Rule List')}}");
                } else if($(this).val() == "POSITION" || $(this).val() == "POSITION_ORGANIZATION_OF_APPLICANT") {
                    $(".node-property .node-owner").attr("data-url", "{{route('position.select', 'select=multiple')}}");
                    $(".node-property .node-owner").attr("data-title", "{{__('Position List')}}");
                }
            });

            $(document).on('click', '.node-property span:not(.show-modal-select)', function() {
                $(this).addClass('show-modal-select');
                $(this).trigger('click');
                $(this).removeClass('show-modal-select');
            });

            $("#btn-save-custom").on('click', function(){
                saveData();
                ajaxMultipartPost($(this));
            });
        });

        function getOperatorData(element) {
            var nbInputs = parseInt(element.data('nb-inputs'), 10);
            var nbOutputs = parseInt(element.data('nb-outputs'), 10);
            var type = element.data('nb-type');
            var operatorData = {
                properties: {
                    id: "",
                    owner_type: "",
                    owner_id: "",
                    notification_id: "",
                    type: type,
                    title: element.attr('title'),
                    editable: "0",
                    auto_approve: "0",
                    reminder_day: "",
                    override: "0",
                    name: "",
                    inputs: {},
                    outputs: {}
                }
            };
            if(type == "START_BRANCH") {
                operatorData.properties.owner_type = "RULE";
            }

            operatorData = createInputOutput(operatorData, nbInputs, nbOutputs);
            return operatorData;
        }

        function makeId(length) {
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }

        function createInputOutput(operator, nbInputs, nbOutputs) {
            for (var i = 1; i <= nbInputs; i++) {
                operator.properties.inputs["in_" + i] = {
                    label: ''
                };
            }
            for (var i = 1; i <= nbOutputs; i++) {
                operator.properties.outputs["out_" + i] = {
                    label: ''
                };
            }
            
            return operator;
        }

        function setHeaderColor() {
            $('.flowchart-operator-title:contains("Applicant")').css('background', '#B0CEF9');
            $('.flowchart-operator-title:contains("Approver")').css('background', '#A4E1A0');
            $('.flowchart-operator-title:contains("Start Branch")').css('background', '#FFE6CC');
            $('.flowchart-operator-title:contains("End Branch")').css('background', '#FFE6CC');
            $('.flowchart-operator-title:contains("Notification")').css('background', '#D7C1E1');
        }

        function prepareData() {
            var operators = new Object();
            var links = new Object();
            
            @foreach($data->nodes as $node)
                var operator = {
                    top: "{{$node->position_top}}",
                    left: "{{$node->position_left}}",
                    properties: {
                        id: "{{$node->id}}",
                        type: "{{$node->node_type}}",
                        owner_type: "{{$node->node_owner_type}}",
                        owner_id: {!!$node->nodeOwners()->pluck('owner_id')!!},
                        notification_id: {!!$node->nodeNotifications()->pluck('notification_template_id')!!},
                        inputs: {},
                        outputs: {}
                    }
                };

                if("{{$node->node_type}}" == "START"){
                    operator.properties.title = "Start";
                    operator = createInputOutput(operator, 0, 1);
                } else if ("{{$node->node_type}}" == "APPLICANT") {
                    operator.properties.title = "Applicant";
                    operator = createInputOutput(operator, 1, 1);
                } else if ("{{$node->node_type}}" == "APPROVER") {
                    operator.properties.title = "Approver";
                    operator = createInputOutput(operator, 1, 1);
                } else if ("{{$node->node_type}}" == "START_BRANCH") {
                    operator.properties.title = "Start Branch";
                    operator = createInputOutput(operator, 1, 2);
                } else if ("{{$node->node_type}}" == "END_BRANCH") {
                    operator.properties.title = "End Branch";
                    operator = createInputOutput(operator, 2, 1);
                } else if ("{{$node->node_type}}" == "END") {
                    operator.properties.title = "End";
                    operator = createInputOutput(operator, 1, 0);
                } else if ("{{$node->node_type}}" == "NOTIFICATION") {
                    operator.properties.title = "Notification";
                    operator = createInputOutput(operator, 1, 1);
                }
                
                operators["{{$node->id}}"] = operator;
                if("{{$node->next_node1_id ?? ''}}" != "") {
                    var link = {
                        fromOperator: '{{$node->id}}',
                        fromConnector: 'out_1',
                        toOperator: '{{$node->next_node1_id}}',
                        toConnector: 'in_{{$node->connector1 ?? ''}}',
                    }
                    links["{{$node->id}}1"] = link;
                }
                if("{{$node->next_node2_id ?? ''}}" != "") {
                    var link = {
                        fromOperator: '{{$node->id}}',
                        fromConnector: 'out_2',
                        toOperator: '{{$node->next_node2_id}}',
                        toConnector: 'in_{{$node->connector2 ?? ''}}',
                    }
                    links["{{$node->id}}2"] = link;
                }
            @endforeach

            return {
                operators: operators,
                links: links,
            }
        }

        function onNotificationSelected(data)
        {
            notificationIds = selectedIds;
            selectedIds = [];
            $('.node-property .node-notification').html(notificationIds.length + " Notification");
        }

        function onOwnerSelected(data)
        {
            ownerIds = selectedIds;
            selectedIds = [];
            $('.node-property .node-owner').html(ownerIds.length + " Node Owner");
        }

        function saveData()
        {
            var data = flowchart.flowchart('getData');
			var nodes = new Object();
			
			for (var key in data.operators) {
				var operator = data.operators[key];				
				var node = {
					id: operator.properties.id,
					nodeType: operator.properties.type,
					nodeOwnerType: operator.properties.owner_type,
					nodeOwnerId: operator.properties.owner_id,
					nodeNotificationId: operator.properties.notification_id,
					nextNode1Id: "",
					nextNode2Id: "",
					positionTop: operator.top,
					positionLeft: operator.left,
					connector1: "",
					connector2: "",
				};
				
				nodes[key] = node;
			}
			
			for (var key in data.links) {
				var link = data.links[key];
				var toOperator = nodes[link.toOperator];
				if(link.fromConnector == "out_1") {
					if(toOperator.id == null || toOperator.id == "") {
						nodes[link.fromOperator].nextNode1Id = link.toOperator;	
					} else {
						nodes[link.fromOperator].nextNode1Id = toOperator.id;
					}
					nodes[link.fromOperator].connector1 = link.toConnector.replaceAll("in_", "");
				} else {
					if(toOperator.id == null || toOperator.id == "") {
						nodes[link.fromOperator].nextNode2Id = link.toOperator;	
					} else {
						nodes[link.fromOperator].nextNode2Id = toOperator.id;
					}
					nodes[link.fromOperator].connector2 = link.toConnector.replaceAll("in_", "");
				}
			}
			
			$("#additionalInput").empty();
			var i = 0;
			for (var key in nodes) {
				var node = nodes[key];
				$("#additionalInput").append('<input type="hidden" name="node['+i+'][id]" value="'+node.id+'">');
				$("#additionalInput").append('<input type="hidden" name="node['+i+'][temp_id]" value="'+key+'">');
				$("#additionalInput").append('<input type="hidden" name="node['+i+'][node_type]" value="'+node.nodeType+'">');
				$("#additionalInput").append('<input type="hidden" name="node['+i+'][node_owner_type]" value="'+node.nodeOwnerType+'">');
				$("#additionalInput").append('<input type="hidden" name="node['+i+'][next_node1_id]" value="'+node.nextNode1Id+'">');
				$("#additionalInput").append('<input type="hidden" name="node['+i+'][next_node2_id]" value="'+node.nextNode2Id+'">');
				$("#additionalInput").append('<input type="hidden" name="node['+i+'][position_top]" value="'+node.positionTop+'">');
				$("#additionalInput").append('<input type="hidden" name="node['+i+'][position_left]" value="'+node.positionLeft+'">');
				$("#additionalInput").append('<input type="hidden" name="node['+i+'][connector1]" value="'+node.connector1+'">');
				$("#additionalInput").append('<input type="hidden" name="node['+i+'][connector2]" value="'+node.connector2+'">');
				
				for(var j = 0; j < node.nodeOwnerId.length; j++) {
					$("#additionalInput").append('<input type="hidden" name="node['+i+'][owner_id]['+j+']" value="'+node.nodeOwnerId[j]+'">');
				}
				for(var j = 0; j < node.nodeNotificationId.length; j++) {
					$("#additionalInput").append('<input type="hidden" name="node['+i+'][notification_id]['+j+']" value="'+node.nodeNotificationId[j]+'">');
				}
				
				i++;
			}
        }

    </script>
@endsection